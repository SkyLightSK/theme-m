jQuery(document).ready(function ($) {

    $('.widget_categories a , .widget_recent_entries a, .widget_archive a').click(function (e) {
        e.preventDefault();

        var link = $(this).attr('href');
        var title = $(this).text();

        document.title = title;
        history.pushState({page_title: title}, title, link);

        var data = {
            action: 'mogul_cat_action',
            link: link
        };

        /**
         * Ajax posts by link
         *
         * @param link target link
         */
        jQuery.post( ajax.url, data, function(response) {
            $('.site-main')
                .animate({opacity: 0.5}, 300)
                .html(response)
                .animate({opacity: 1}, 300);
        });

    });

    //Post content ajax call

    $('.services-header .mogul-nav-pills a, .portfolio-header .mogul-nav-pills a').click(function (e) {
        e.preventDefault();

        var postId = $(this).attr('data-id');
        var postType = $(this).attr('data-post-type');

        var data = {
            action: 'mogul_post_content_action',
            postId: postId,
            postType: postType
        };

        /**
         * Ajax posts by id
         *
         * @param id target class
         */
        jQuery.post( ajax.url, data, function(response) {
            $('.tab-content')
                .animate({opacity: 0.5}, 300)
                .html(response)
                .animate({opacity: 1}, 300);
        });

    });

    $('.review-load-more').click(function () {

        var that = $(this);

        that.addClass('loading').attr('disabled','disabled');
        that.attr('disabled','disabled');

        var lastPage = that.attr('data-last-page');
        var pageNumber = $(this).attr('data-page');
        var newPage = parseInt(pageNumber) + 1 ;

        var data = {
            action: 'mogul_reviews_action',
            pageNumber: newPage
        };

        /**
         * Ajax posts by id
         *
         * @param id target posts
         */
        $.ajax({
           url: ajax.url,
           type: 'post',
           data: data,
           error : function ( response ) {
               console.log( response );
           },
           success : function ( response ) {

               // newNumber = that.data('page') + 1;
               that.attr('data-page', newPage);
               that.removeAttr('disabled');

               that.removeClass('loading');

               newPage == lastPage ? that.remove() : "" ;

               $('.review-list').append( response );

           } 
        });

    });


    $('.additional_review_item a').click(function (e) {

        e.preventDefault();

        $('.additional-reviews-popup').addClass('loading');

        var that = $(this);
        var post_id = $('.additional-reviews-list').attr('data-post-id');
        var additional_id = that.attr('data-additional-id');

        console.log(post_id + ' ' + additional_id);

        var data = {
            action: 'mogul_additional_action',
            additional_id: additional_id,
            post_id: post_id
        };

        /**
         * Ajax additional reviews
         *
         * @param acf target content
         */
        $.ajax({
            url: ajax.url,
            type: 'post',
            data: data,
            error: function (response) {
                console.log('error : ',response);
            },
            success: function (response) {

                that.removeClass('loading');

                var res = JSON.parse(response);

                $('#ModalLongTitle').html(res['additional_review_name']);
                $('.additional-review-description').html(res['additional_review_description']);
                $('.additional-review-logo img').attr('src', res['additional_review_logo']);
                $('.additional-review-url').attr('href', res['additional_review_link']);


            }
        });
    });

    $('.appointment-form-callback, .review-form-callback').click(function (e) {
        e.preventDefault();

        var that = $(this);
        var form_slug = that.attr('data-form-name');
        var title = "New Title";

        $('.hidden-form').removeClass('active');
        $('.main-form').css('display','none');
        $($(this).attr('data-target')).addClass('active');

        $('.entry-title').animate({opacity: 0.5}, 300);

        console.log(form_slug);

        var data = {
            action:        'mogul_contact_form_action',
            form_slug:      form_slug
        };

        /**
         * Ajax contact form
         *
         * @param form slug target contact form content
         */
        $.ajax({
            url: ajax.url,
            type: 'post',
            data: data,
            error : function ( response ) {
                console.log( response );
            },
            success : function ( response ) {

                $('.entry-title')
                    .animate({opacity: 1}, 300)
                    .html( response );
                document.title = response + ' - Mogul';
                history.pushState({page_title: response}, response, form_slug);
            }
        });

    });

});