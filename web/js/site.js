/**
 * Refresh employee form
 */
function callRefreshForm() {
    let formEl = $(document).find('#employee-form');
    if (formEl.length > 0) {
        $.pjax.reload({
            url: formEl.data('refresh-action'),
            container: '#form-pjax',
            timeout: false,
            scrollTo: false
        });
    }
}

/**
 * Employee form submit
 */
function submitForm() {
    $(document).on('submit', '#employee-form', function (e) {
        e.preventDefault();
        let form = $(this),
            formData = new FormData(this);
        formData.set(yii.getCsrfParam(), yii.getCsrfToken());

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: false,
            success: function (r) {
                if (r.success) {
                    $.pjax.reload({
                        container: '#grid-pjax',
                        timeout: false,
                        scrollTo: false
                    }).done(function () {
                        callRefreshForm();
                    });
                }
            },
            error: function (r) {
                console.log(r);
            }
        });
    });
}

/**
 * Update item action
 */
function actionUpdate() {
    $(document).on('click', '[data-handler="update"]', function (e) {
        e.preventDefault();
        let link = $(this);

        $.pjax.reload({
            url: link.data('action'),
            container: '#form-pjax',
            timeout: false,
            scrollTo: false
        });
    });
}

/**
 * Delete item action
 */
function actionDelete() {
    $(document).on('click', '[data-handler="delete"]', function (e) {
        e.preventDefault();
        let link = $(this),
            csrfData = {};
        csrfData[yii.getCsrfParam()] = yii.getCsrfToken();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: link.data('action'),
            data: csrfData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: false,
            success: function (r) {
                if (r.success) {
                    $.pjax.reload({
                        action: link.data('action'),
                        container: '#grid-pjax',
                        timeout: false,
                        scrollTo: false
                    });
                }
            },
            error: function (r) {
                console.log(r);
            }
        });
    });
}

/**
 * Init functions
 */
$(document).ready(function () {
    submitForm();
    actionUpdate();
    actionDelete();
});
