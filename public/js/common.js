$(document).on('click', '.delete', function () {
    let url = $(this).data('url');
    let tableId = '#' + $(this).data('table');
    let reload = $(this).data('reload');
    deleteConfirmation(url, tableId, reload);
});

$(document).on('click', '.userapprove,.userdisapprove', function (e) {
    e.preventDefault();
    let action = $(this).hasClass('userapprove') ? 'accepted' : 'rejected';
    let url = $(this).data('url');
    let user_id = $(this).data('user-id');
    let opportunity_id = $(this).data('opportunity-id');
    let template = `<label>You want to Accept the Request.</label>`;

    if (action == 'rejected') {
        template = `<label>Please, provide reason to reject.</label>
                            <textarea id="rejectionReason" class="form-control" rows="3"></textarea>`;
    }
    window.swal.fire({
        title: 'Are you sure?',
        html: template,
        showCancelButton: true,
        confirmButtonText: "Yes, do it!"
    }).then(function (result) {
        let reason = action == 'rejected' ? $('#rejectionReason').val() : null;
        if (result.isConfirmed == true) {
            window.swal.fire({
                title: "",
                text: "Please wait...",
                showConfirmButton: false,
                backdrop: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    action: action,
                    user_id: user_id,
                    opportunity_id: opportunity_id,
                    reason: reason,
                },
                success: function (response) {
                    if (response.status == 'success') {
                        let user_id= response.user_id;
                        window.swal.close();
                        toastMessage(response.message, response.status);
                    }
                    else {
                        window.swal.close();
                        toastMessage(response.message);
                    }
                    $('#forms-dt').DataTable().ajax.reload();
                },
                error: function (errors) {
                    window.swal.close();
                    toastMessage(errors.message)
                }
            });
        }
    });
});

function deleteConfirmation(url, tableId, reload = false) {
    window.swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this record",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.value) {
            window.swal.fire({
                title: "",
                text: "Please wait...",
                showConfirmButton: false,
                backdrop: true
            });

            window.axios.delete(url).then(response => {
                if (response.status === 200) {
                    window.swal.close();
                    $(tableId).DataTable().ajax.reload();

                    // Show toast message
                    window.toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });

                    if (reload==true) window.location.reload();
                }
            }).catch(error => {
                window.swal.close();
                // Show toast message
                window.toast.fire({
                    icon: 'error',
                    title: error.response.data.message
                });
            });
        }
    });
}

// returns the classes accroding to the status
function statusClasses(status) {
    let divClass = '';
    switch (key) {
        case 'active':
            divClass = 'success';
            break;
        case 'enable':
            divClass = 'success';
            break;
        case 'pending':
            divClass = 'danger';
            break;
        case 'disable':
            divClass = 'danger';
            break;
    }
    return divClass;
}

function toastMessage(message = '', status = '', duration = 3000) {
    status = status=='' ? 'error' : status;

    if (message=='')
        message = status=='error' ? 'Something went wrong' : 'Success';

    window.toast.fire({
        title: message,
        icon: status,
        timer: duration
    });
}

$('body').on('click', '[data-act=ajax-modal]', function () {
    const _self = $(this);

    const content = $("#ajax_model_content");
    const spinner = $("#ajax_model_spinner");

    content.hide();
    spinner.show();

    $("#ajax_model").modal({backdrop: 'static'});
    $("#ajax_model_title").html(_self.attr('data-title'));

    var metaData = {};
    $(this).each(function () {
        $.each(this.attributes, function () {
            if (this.specified && this.name.match("^data-post-")) {
                var dataName = this.name.replace("data-post-", "");
                metaData[dataName] = this.value;
            }
        });
    });

    axios({
        method: _self.attr('data-method'),
        url: _self.attr('data-action-url'),
        data: metaData
    })
    .then(response => {
        spinner.hide();

        if (response.status === 200) content.html(response.data).show();
        else toastMessage();

    }).catch(error => {
        spinner.hide();
        toastMessage(error.response.data.message);
    });
});

$('body').on('submit', '[data-form=ajax-form]', function(e) {
    e.preventDefault();

    const form = this;
    const confirm = $(form).data('confirm');

    if (confirm=='yes') {
        window.swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to submit this form?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, do it!"
        }).then((result) => {
            if (result.value) sendAjaxForm(form);
        });
    } else {
        sendAjaxForm(form);
    }
});

function sendAjaxForm(form) {
    const _self = $(form);
    const btn = _self.find('[data-button=submit]');
    const btnHtml = btn.html();
    const modal = _self.data('modal');
    const dt = _self.data('datatable');
    const reload = _self.data('reload');
    const redirect = _self.data('redirect');

    btn.attr('disabled', 'disabled');
    btn.html(btnHtml + '&nbsp;&nbsp;<span class="spinner-border spinner-border-sm"></span>');
    $("#form-pointer").css('pointer-events','none');

    axios({
        url: _self.attr('action'),
        method: _self.attr('method'),
        data: new FormData(_self[0]),
    })
    .then(response => {
        if (response.status == 200) {
            if (modal !== '') $(modal).modal('hide');
            if (dt !== '') $(dt).DataTable().ajax.reload();

            toastMessage(response.data.message, 'success');

            if (reload==true) window.location.reload();

            if (redirect) {
                window.location.href = redirect;
            }
        }

        else toastMessage();
    })
    .catch(error => {
        toastMessage(error.response.data.message);
    })
    .finally(response => {
        btn.removeAttr('disabled');
        btn.html(btnHtml);
        $("#form-pointer").css('pointer-events','auto');
    });
}

// to show uploaded image
function addFileEventToLabel(file_id, label_id, preview_id) {
    // for board signature
    const label = document.getElementById(label_id),
        file_input = document.getElementById(file_id),
        preview = document.getElementById(preview_id);

    label.addEventListener("click", function (e) {
        if (file_input) {
            file_input.click();
        }
        e.preventDefault(); // prevent form default action sign_image_preview
    }, false);

    file_input.addEventListener('change', function () {
        const file = file_input.files[0];
        let reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
            $('#upload-btn').show();
        }
    });
}

// to approve and disapprove user
$(document).on('click', '.approve, .disapprove', function () {
    let url = $(this).data('url');
    let tableId = $(this).data('table');
    let tr = $(this).closest('tr');
    let rowData = $(tableId).DataTable().row(tr).data();
    let action = $(this).hasClass('approve') ? 'active' : 'rejected';

    var data = {
        'id': rowData.id,
        'status': action,
    }

    processRequest(url, tableId, data);
});

// to process the request of approval and disapproval
function processRequest(url, tableId, formData) {
    var message = formData.status === 'active'
        ? `<label class="col-form-label">
                You want to approve this
            </label>`
        : `<label class="col-form-label">
                Please, provide disapproval reason:
            </label>
            <textarea name="rejected_reason" id="disapproval_reason" class="form-control" rows="3"></textarea>`;
    window.swal.fire({
        title: 'Are you sure?',
        type: 'warning',
        html: message,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
    }).then((result) => {
        formData['rejected_reason'] = $('[name=rejected_reason]').val()
        if (result.value) {
            window.swal.fire({
                title: "",
                text: "Please wait...",
                showConfirmButton: false,
                backdrop: true
            });
            window.axios.post(url, formData).then(response => {
                if (response.status === 200) {
                    window.swal.close();
                    $(tableId).DataTable().ajax.reload();

                    // Show toast message
                    window.toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                }
            }).catch(error => {
                window.swal.close();
                // Show toast message
                window.toast.fire({
                    icon: 'error',
                    title: error.response.data.message
                });
            });
        }
    });
}

$(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if (month < 10) month = '0' + month.toString();
    if (day < 10) day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;
    $('.date').attr('min', maxDate);
});

$(function(){
    function filevalidation(id,attr){
        $("#"+id).on("change", function (e) {
            var files = e.currentTarget.files;
            var mbs = files[0].size/1024/1024;
            if(mbs > 5 ){
                toastMessage("The "+attr+" may not be greater than 5 MBs.");
                $("#"+id).val('');
            }
        });
    }
    filevalidation('beezerPassportImage','passport picture');
});