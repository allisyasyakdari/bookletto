function openModalImpl(tab){
    const overlay = document.getElementById('modal');
    if(!overlay) return;
    // compensate for scrollbar disappearance to avoid horizontal shift
    const scrollComp = window.innerWidth - document.documentElement.clientWidth;
    if (scrollComp > 0) {
        // store previous padding-right
        window.__booklettoPrevBodyPaddingRight = document.body.style.paddingRight || '';
        document.body.style.paddingRight = (parseFloat(getComputedStyle(document.body).paddingRight) || 0) + scrollComp + 'px';
    }
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';

    // panels
    document.querySelectorAll('.modal-panel').forEach(el => {
        el.classList.remove('active');
        el.classList.add('hidden');
    });
    const panel = document.getElementById((tab === 'register' ? 'register-panel' : 'login-panel'));
    if(panel){
        panel.classList.remove('hidden');
        panel.classList.add('active');
        // focus first input for better UX
        const input = panel.querySelector('input, button, a');
        if(input) input.focus();
    }
}

function closeModalImpl(){
    const overlay = document.getElementById('modal');
    if(!overlay) return;
    overlay.classList.remove('open');
    document.body.style.overflow = '';
    // restore previous body padding-right
    if (typeof window.__booklettoPrevBodyPaddingRight !== 'undefined') {
        document.body.style.paddingRight = window.__booklettoPrevBodyPaddingRight;
        delete window.__booklettoPrevBodyPaddingRight;
    }
    document.querySelectorAll('.modal-panel').forEach(el => { el.classList.remove('active'); el.classList.add('hidden'); });
}

function handleOverlayClick(e){
    if(!e) return;
    if(e.target && e.target.id === 'modal') closeModalImpl();
}

// expose for inline fallback
window.__booklettoOpenModal = openModalImpl;
window.__booklettoCloseModal = closeModalImpl;
window.__booklettoHandleOverlay = handleOverlayClick;

// attach delegated handler in case inline onclick isn't used
document.addEventListener('click', function(e){
    const el = e.target;
    if(el && el.matches && el.matches('[data-open-modal]')){
        e.preventDefault();
        const tab = el.getAttribute('data-open-modal') || 'login';
        openModalImpl(tab);
    }
});

// Robust overlay handling: ensure clicks directly on overlay close modal,
// and that clicks inside the card don't propagate.
document.addEventListener('DOMContentLoaded', function(){
    const overlay = document.getElementById('modal');
    if(!overlay) return;
    // close when clicking on the backdrop (ensure exact target match)
    overlay.addEventListener('pointerdown', function(e){
        if (e.target === overlay) closeModalImpl();
    });
    // prevent accidental propagation from the card itself
    const card = overlay.querySelector('.mcard');
    if(card){
        card.addEventListener('pointerdown', function(e){
            e.stopPropagation();
        });
    }
});

export { openModalImpl as openModal, closeModalImpl as closeModal };
