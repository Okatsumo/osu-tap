<x-main-layout>
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <div class="maps">
            <div class="maps__item">
                <a href="#" class="covers">
                    <div class="play">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/list.jpg?1703127096" alt="cover">
                    </div>
                    <div class="info">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/cover.jpg?1703127096" alt="cover">
                    </div>
                </a>

                <div class="content">
                    <div class="play">

                    </div>
                    <div class="info">
                        <p>TSF in Japan!</p>
                        <p>От DJ Mii-ko & Kazmasa</p>
                        <p>Автор: -Maruko-</p>
                    </div>
                </div>

            </div>

            <div class="maps__item">
                <a href="#" class="covers">
                    <div class="play">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/list.jpg?1703127096" alt="cover">
                    </div>
                    <div class="info">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/cover.jpg?1703127096" alt="cover">
                    </div>
                </a>

                <div class="content">
                    <div class="play">

                    </div>
                    <div class="info">
                        <p>TSF in Japan!</p>
                        <p>От DJ Mii-ko & Kazmasa</p>
                        <p>Автор: -Maruko-</p>
                    </div>
                </div>

            </div>

            <div class="maps__item">
                <a href="#" class="covers">
                    <div class="play">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/list.jpg?1703127096" alt="cover">
                    </div>
                    <div class="info">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/cover.jpg?1703127096" alt="cover">
                    </div>
                </a>

                <div class="content">
                    <div class="play">

                    </div>
                    <div class="info">
                        <p>TSF in Japan!</p>
                        <p>От DJ Mii-ko & Kazmasa</p>
                        <p>Автор: -Maruko-</p>
                    </div>
                </div>

            </div>

            <div class="maps__item">
                <a href="#" class="covers">
                    <div class="play">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/list.jpg?1703127096" alt="cover">
                    </div>
                    <div class="info">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/cover.jpg?1703127096" alt="cover">
                    </div>
                </a>

                <div class="content">
                    <div class="play">

                    </div>
                    <div class="info">
                        <p>TSF in Japan!</p>
                        <p>От DJ Mii-ko & Kazmasa</p>
                        <p>Автор: -Maruko-</p>
                    </div>
                </div>

            </div>

            <div class="maps__item">
                <a href="#" class="covers">
                    <div class="play">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/list.jpg?1703127096" alt="cover">
                    </div>
                    <div class="info">
                        <img src="https://assets.ppy.sh/beatmaps/1984492/covers/cover.jpg?1703127096" alt="cover">
                    </div>
                </a>

                <div class="content">
                    <div class="play">

                    </div>
                    <div class="info">
                        <p>TSF in Japan!</p>
                        <p>От DJ Mii-ko & Kazmasa</p>
                        <p>Автор: -Maruko-</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-main-layout>


<style>
    .maps {
        display: grid;
        justify-content: center;
        grid-gap: 12px;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(3, 1fr);
    }
    .maps__item > .covers {
        display: flex;
        position: absolute;

    }

    .maps__item .play {
        width: 120px;
    }

    .maps__item > .covers img {
        height: 120px;
    }

    .maps__item > .content {
        position: relative;
        display: flex;
        color: #FFFF;
    }

    .maps__item > .content > .info {
        padding: 4px 14px;
        background: #0b1118d9;
    }

    .maps__item > .content .info {
        height: 120px;
        width: 433px;
    }

</style>
