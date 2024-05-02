export class MenuModal {

    constructor() {
        this.col_menu = document.getElementsByClassName('nav__col--menu')[0]
        this.nav_bg = document.getElementsByClassName('nav__menu--bg')[0]
        this.menu_link = this.col_menu.getElementsByClassName('nav__link')[0]
        this.menu = this.col_menu.getElementsByClassName('nav__menu')[0]
        this.header = document.getElementsByTagName('header')[0]
        this.window = window

        this.onClicks = this.onClicks.bind(this);
        this.update = this.update.bind(this);
    }

    init() {
        this.menu.style.display = 'none'
        this.onClicks()
    }

    onClicks() {
        this.menu_link.onclick = function () {
            this.openAndClose()
        }.bind(this);

        this.nav_bg.onclick = function () {
            this.openAndClose()
        }.bind(this);
    }

    openAndClose() {
        if (this.menu.style.display === 'none') {
            this.open()
        } else {
            this.close()
        }
    }

    open(){
        window.addEventListener('resize', this.update);
        this.update()
        this.menu.style.display = 'block';
        this.nav_bg.style.display = 'block'
    }

    close() {
        window.removeEventListener('resize', this.update);

        this.menu.style.display = 'none';
        this.nav_bg.style.display = 'none'
    }

    update() {
        let modal_right = this.menu.getBoundingClientRect().right
        let header_rect = this.header.getBoundingClientRect().right
        let window_right = this.window.innerWidth;
        let content = this.menu.getElementsByClassName('nav__menu--content')[0]
        const offset = 28;

        // Мобильный экран
        if (window_right <= 990) {
            this.setTranslateX(0)
            content.style.width = `${window_right - 24}px`

        } else {
            content.style.width = '280px'

            //Меню касается экрана
            if (modal_right + 10 >= header_rect) {
                let translateX = window_right - this.menu.offsetWidth - offset;

                this.setTranslateX(translateX)
            } else {
                this.setDefaultTranslateX()
            }
        }
    }

    setTranslateX(translateX)
    {
        this.menu.style.transform = `translateX(${translateX}px)`
    }

    setDefaultTranslateX()
    {
        let nav_menu_right = this.menu_link.getBoundingClientRect().right
        let translateX = nav_menu_right - 170

        this.setTranslateX(translateX)
    }
}
