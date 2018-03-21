var renderPopup = function (jsEvent, start, end, calEvent) {
    var $popup = $('#calendar-popup');
    var $eventForm = $('#event-form');
    $event = $('#event');
    var $selectedElmt = $(jsEvent.target);

    $event.hide();
    $('#appointment_form_start').val(start.format('YYYY-MM-DD[T]HH:mm'));
    $('#appointment_form_end').val(end.format('YYYY-MM-DD[T]HH:mm'));
    if (calEvent) {
        $('#appointment_id').val(calEvent.id);
    }
    $eventForm.show();

    var leftPosition = 0;
    var $prong = $('.prong');
    var prongPos = 0;

    if ($selectedElmt.hasClass('fc-highlight')) {
        leftPosition = $selectedElmt.offset().left - $popup.width() + ($selectedElmt.width() / 2);
        if (leftPosition <= 0) {
            leftPosition = 5;
            prongPos = $popup.width() - $selectedElmt.offset().left - 30
        }
        else {
            prongPos = 15;
        }

        $popup.css('left', leftPosition);
        $prong.css({
            'left': '',
            'right': prongPos,
            'float': 'right'
        });
    }
    else {
        leftPosition = jsEvent.originalEvent.pageX - $popup.width() / 2;
        if (leftPosition <= 0) {
            leftPosition = 5;
        }
        prongPos = jsEvent.originalEvent.pageX - leftPosition - ($prong.width() * 1.7);

        $popup.css('left', leftPosition);
        $prong.css({
            'left': prongPos,
            'float': 'none',
            'right': ''
        });
    }

    var topPosition = (calEvent ? jsEvent.originalEvent.pageY : $selectedElmt.offset().top) - $popup.height() - 15;

    if ((topPosition <= window.pageYOffset)
        && !((topPosition + $popup.height()) > window.innerHeight)) {
        $popup.css('top', jsEvent.originalEvent.pageY + 15);
        $prong.css('top', -($popup.height() + 12))
            .children('div:first-child').removeClass('bottom-prong-dk').addClass('top-prong-dk')
            .next().removeClass('bottom-prong-lt').addClass('top-prong-lt');
    }
    else {
        $popup.css('top', topPosition);
        $prong.css({'top': 0, 'bottom': 0})
            .children('div:first-child').removeClass('top-prong-dk').addClass('bottom-prong-dk')
            .next().removeClass('top-prong-lt').addClass('bottom-prong-lt');
    }

    $popup.show();
    $popup.find('input[type="text"]:first').focus();
}

$(document).ready(function () {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'agendaWeek,agendaDay'
        },
        timezone: 'local',
        defaultView: 'agendaWeek',
        allDayDefault: false,
        allDaySlot: false,
        slotEventOverlap: true,
        slotDuration: "00:30:00",
        slotLabelInterval: "00:15:00",
        snapDuration: "00:15:00",
        contentHeight: 'auto',
        scrollTime: "8:00:00",
        axisFormat: 'h:mm a',
        timeFormat: 'h:mm A()',
        minTime: '08:00:00',
        maxTime: '18:00:00',
        selectable: true,
        events: function (start, end, timezone, callback) {
            callback(events);
        },
        // eventColor: '#378006',
        eventClick: function (calEvent, jsEvent) {
            renderPopup(jsEvent, calEvent.start, calEvent.end, calEvent);
        },
        select: false
    });

    //Set hide action for ESC key event
    $('#calendar-popup').on('keydown', function (e) {
        $this = $(this);
        if ($this.is(':visible') && e.which === 27) {
            $this.blur();
        }
    })
    //Set hide action for lost focus event
        .on('focusout', function (e) {
            $this = $(this);
            if ($this.is(':visible') && !$(e.relatedTarget).is('#calendar-popup, #calendar-popup *')) {
                $this.hide();
            }
        });
});
