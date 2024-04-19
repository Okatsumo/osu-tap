<?php

namespace App\Jobs\Parser\Beatmapsets;

use App\Contracts\Jobs\BaseOsuParser as Contract;
use App\Repository\BeatmapsetsRepository;
use App\Repository\OsuAccountRepository;
use App\Services\Osu\Api\Throttle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class BaseOsuParser implements ShouldQueue, Contract
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Throttle $throttle;
    protected int $tries = 0;
    protected $request;
    protected string $request_class;
    protected BeatmapsetsRepository $beatmapsetsRepo;
    protected OsuAccountRepository $accountRepo;

    public function prepare(): void
    {
        $this->throttle = new Throttle(config('services.osu.throttle_settings'));
        $this->request = app($this->request_class);
        $this->beatmapsetsRepo = new BeatmapsetsRepository();
        $this->accountRepo = new OsuAccountRepository();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->prepare();
        $account = $this->setAccount();

        /*
         * Нет активного аккаунта, откладывание задачи.
         */
        if (is_null($account)) {
            $this->release($this->throttle->getTimeOut());

        } else {
            $this->throttle->addCount();

            /*
             * Аккаунт находится в тротлинге.
             */
            if ($this->throttle->check()) {
                /**
                 * Попытка сменить аккаунт на аккаунт без тротлинга.
                 */
                $account = $this->setAccount();
            }

            /*
             * Есть активный аккаунт.
             */
            if (!is_null($account)) {
                $this->parse();
            } else {
                /*
                 * Аккаунтов не нашлось, откладывание задачи
                 */
                $this->release($this->throttle->getTimeOut());
            }
        }

    }

    public function setAccount(): ?\App\Services\Osu\Dto\OsuAccount
    {
        $account = $this->accountRepo->getActive();

        if (is_null($account)) {
            $id = $this->accountRepo->getFirstAccountId();
            $this->throttle->setAccountId($id);

        } else {
            $this->request->setAccount($account);
            $this->throttle->setAccountId($account->id);
        }

        return $account;
    }
}
