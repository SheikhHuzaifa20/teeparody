<style>
    #cartOffcanvas {
        z-index: 999999 !important;
        width: 400px;
        max-width: 90vw;
    }
    .offcanvas-backdrop.show {
        z-index: 999998 !important;
    }
</style>

<!-- Side Cart Offcanvas Drawer -->
<div class="offcanvas offcanvas-end shadow-lg" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
    <div class="offcanvas-header text-white p-3" style="background-color: #006bef;">
        <h5 class="offcanvas-title d-flex align-items-center fw-bold" id="cartOffcanvasLabel">
            <i class="fa-solid fa-cart-shopping me-2 text-white"></i> Shopping Cart
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3 bg-light" id="cartDrawerBody">
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer p-3 border-top bg-white" id="cartDrawerFooter">
    </div>
</div>
