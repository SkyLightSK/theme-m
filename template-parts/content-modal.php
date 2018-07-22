<?php
/**
 * Template part for displaying modal in reviews.php template
 *
 * @package Mogul
 */
?>
<div class="additional-reviews-popup modal fade" id="additionalModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="ModalLongTitle"><?php _e( 'Modal title', 'mogul' ); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="additional-review-logo">
                    <a class="additional-review-url" href="#" target="_blank">
                        <img src="" alt="">
                    </a>
                </div>
                <div class="additional-review-description"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'Close', 'mogul' ); ?></button>
                <button type="button" class="btn btn-primary"><a class="additional-review-url" target="_blank" href="#"><?php _e( 'Go To', 'mogul' ); ?></a></button>
            </div>
        </div>
    </div>
</div>

