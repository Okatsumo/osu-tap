import './bootstrap';
import './MenuModal.js'
window.addEventListener('scroll', function() {
    if (window.innerHeight + window.scrollY + 120 >= document.body.offsetHeight) {
        Livewire.dispatch('loadMore')
    }
});
