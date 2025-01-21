<div class="modal zt-login-modal fade" id="termsPopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="z-index:1000" role="document">
        <div class="modal-content">
            <button type="button" class="close model-cross" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="position-relative">
                <div class="text-center pera-content">
                    <div class="modal-body text-left" style="height:400px; overflow-x:scroll;">
                        <h3 style="text-decoration: underline;text-underline-position: under;"
                            class="title text-center font-weight-bold mb-4">Terms & Conditions</h3>
                        {!! $terms?->content !!}
                        <button class="btn d-block ml-auto mt-4 continue-btn" data-toggle="modal"
                            data-target="#checkoutpopup" data-dismiss="modal" aria-label="Close">Agree</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
