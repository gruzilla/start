'use strict';
/* global $ */
/* global console */
/* global dialogPolyfill */

function priorityUp(event) {
    var id = $($(event.target).parents('.mdl-cell').get(0)).attr('id');
    var idPrev = $($(event.target).parents('.mdl-cell').get(0)).prev('.mdl-cell').attr('id');
    if (!idPrev) return;
    console.log(id, idPrev);
}

function priorityDown(event) {
    var id = $($(event.target).parents('.mdl-cell').get(0)).attr('id');
    var idNext = $($(event.target).parents('.mdl-cell').get(0)).next('.mdl-cell').attr('id');
    if (!idNext) return;
    console.log(id, idNext);
}

function initLogDialog() {
    var dialog = document.querySelector('#log-dialog');
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    $('.js-log').click(function() {
        var id = $($(this).parents('.mdl-cell').get(0)).attr('id');
        $.get('getLog.php?project=' + id).then(function(data) {
            var html = '<ul class="mdl-list">' +
                data.map(function(log) {
                    return '<li class="mdl-list__item mdl-list__item--two-line">'+
                            '<span class="mdl-list__item-primary-content">'+
                            '  <span>' + log.log_entry + '</span>'+
                            '  <span class="mdl-list__item-sub-title">' + log.created + '</span>'+
                            '</span></li>';
                }).join('') + '</ul>';
            $('#log-dialog .mdl-dialog__content').html(html);
            $('#log-dialog .add').data('id', id);
            dialog.showModal();
        });
    });
    $('#log-dialog .close').click(function() {
        dialog.close();
    });
}

function initAddDialog() {
    var dialog = document.querySelector('#add-log-dialog');
    var logDialog = document.querySelector('#log-dialog');
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    $('#log-dialog .add').click(function() {
        var id = $(this).data('id');
        $('#add-log-dialog .save').data('id', id);
        logDialog.close();
        dialog.showModal();
    });
    $('#add-log-dialog .save').click(function() {
        var id = $(this).data('id');
        var data = $('#add-log-dialog textarea').val();
        $.post('addLog.php', {id: id, data: data}).then(function() {
            dialog.close();
        });
    });
}

$(document).init(function() {
    $('.js-priority-up').on('click', priorityUp);
    $('.js-priority-down').on('click', priorityDown);
    initLogDialog();
    initAddDialog();
});

