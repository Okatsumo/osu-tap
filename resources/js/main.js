import './app.js'
import {MenuModal} from './MenuModal.js'

function reinitializeMenu() {
    let menu = new MenuModal();
    menu.init();
}

Livewire.hook('component.init', () => {
    reinitializeMenu()
});
