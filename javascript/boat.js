var loader;
var scrolledDown = false;

$('#input form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      $($(this).find('button')).click();
      return false;
    }
  });

$(document).ready(function () {
    $('#userQuery').on('keyup keydown paste', function () {
        var query = $(this).val();

        if (query != "") {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $('.dropdown').remove();

                    var result = '';
                    result += '<div class="dropdown">';
                    
                    result += '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: inline; margin-top: -5px;">';

                    if (this.responseText != '') {
                        this.responseText.split('\\n').forEach(user => {
                            var fields = user.split(',');
                            result += '<a class="dropdown-item" style="cursor: pointer;" user-id=' + fields[0] + ' onclick=selectUser("' + fields[0] + '","' + fields[1] + '","' + fields[2] + '","' + fields[3] + '")>';
                            result += fields[1] + ' ';
                            result += fields[2] + ' ';
                            result += '<span style="font-size:.75em;">' + fields[3] + '</span>';
                            result += '</a>';
                        });
                    } else {
                        result += '<a class="dropdown-item">';
                        result += 'No Result';
                        result += '</a>';
                    }

                    result += '</div>';
                    result += '</div>';

                    $('#userQuery').parent().append(result);
                    $('#dropdownMenuButton').click();
                    
                    /*
                    <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown button
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                    </div>
                    */
                }
            };
            xmlhttp.open("GET", "?action=aQueryUser&query=" + query, true);
            xmlhttp.send();
        } else {
            $('.dropdown').remove();
        }
    });

    //notification bell
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#navigation-link').html(this.responseText);
            
            loadNotificationBell();
            loader = setInterval(loadNotificationBell, 1000);
        }
    };
    
    xmlhttp.open("GET", "?action=aLoadNotificationBell", true);
    xmlhttp.send();
});

function selectUser(id, firstname, lastname, email) {   
    // TODO: Remove email 
    if (!($('#userIds').val()).split(',').includes(id)) {
        $('#userIds').val($('#userIds').val() + id + ',');

        var memberBadge = '';
        memberBadge += '<div user-id="' + id + '" class="badge badge-primary text-wrap align-middle" style="width: 6rem; margin: 5px;">';

        memberBadge += '<button type="button" class="close text-white" aria-label="Close" onclick=removeUser('+ id +')>';
        memberBadge += '<span aria-hidden="true">&times;</span>';
        memberBadge += '</button>';

        memberBadge += firstname + ' ' + lastname;
        memberBadge += '</div>';

        $('#members').append(memberBadge);

        $('#userQuery').val('');
        $('.dropdown').remove();
    }
}

function removeUser(id) {
    var ids = ($('#userIds').val()).split(',');
    ids = jQuery.grep(ids, function(value) { return value != id; });
    $('#userIds').val(ids.join(','));

    $('.badge[user-id=' + id + ']').remove();
}

function openGroup(sender) {
    scrolledDown = false;

    $(sender).parent().find('.nav-link').removeClass('active');
    $($(sender).parent().find('.nav-link')[0]).addClass('active');
    $(sender).addClass('active');

    var groupId = $(sender).attr('group-id');

    if (groupId != null) {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $('#messages').html(this.responseText);
                $('#input').removeAttr("hidden");
                
                loadMessages();
                loader = setInterval(loadMessages, 1000);
            }
        };
        
        xmlhttp.open("GET", "?action=aOpenGroup&groupId=" + groupId, true);
        xmlhttp.send();
    }
}

function sendMessage(sender) {
    var message = $(sender).parent().parent().find('input').val();

    if (message != '') {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            }
        };
        
        xmlhttp.open("GET", '?action=aSendMessage&message=' + message, true);
        xmlhttp.send();
    }

    $(sender).parent().parent().find('input').val('');
}

function loadMessages() {
    $.ajax({
        url: "?action=aLoadMessages",
        type: "get"
    })
    .done(function (response, textStatus, jqXHR) {
        $('#messages').html(formatMessages(response));
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
        console.log("done");
        if (scrolledDown == false) {

            $("html, body").scrollTop($(document).height());
            scrolledDown = true;
        }
    });
}

function formatMessages(rawMessages) {
    // TODO: Pull messages down

    var result = '';
    rawMessages.split('\\n').forEach(message => {
        var fields = message.split(',');

        result += "<div message-id='" + fields[4] + "' class='message container-fluid align-text-bottom'>";

        if (fields[0] != "true") {
            result += "<div class='row'>";
            result += "<div class='col'>";
            result += "<span class='user'>" + fields[1] + ' ' + fields[2] + "</span>";
            result += "</div>";
            result += "</div>";
        }

        result += "<div class='row'>";
        result += "<div class='col'>";
        result += "<span class='bg-light px-3 py-1 m-1 rounded" + (fields[0] == "true" ? " float-right" : " float-left") + "'>";
        result += "<span class='data'>" + fields[5] + "</span>";
        result += "</div>";
        result += "</div>";
        result += "<div class='row mb-2'>"
        result += "<div class='col'>";
        result += "<span class='date badge text-muted font-weight-light" + (fields[0] == "true" ? " float-right" : "") + "'>" + fields[3] + "</span>";
        result += "</span>";
        result += "</div>";
        result += "</div>";
        result += "</div>";
    });
    return result;
}

function loadNotificationBell() {
    $.ajax({
        url: "?action=aLoadNotificationBell",
        type: "get"
    })
    .done(function (response, textStatus, jqXHR) {
        $('#navigation-link').html(formatNotificationBell(response));
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
        console.log("done");
    });
}

function formatNotificationBell(hasNotifications) {
    // TODO: Pull messages down
    var result = '<li class="nav-item"><a class="nav-link" href="#" data-target="#notifcationModal" data-toggle="modal">';
    if(hasNotifications == 'true')
    {
        result += '<svg class="bi bi-bell-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="red" xmlns="http://www.w3.org/2000/svg"><path d="M8 16a2 2 0 002-2H6a2 2 0 002 2zm.995-14.901a1 1 0 10-1.99 0A5.002 5.002 0 003 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/></svg>';
    }
    else if(hasNotifications == 'false')
    {
        result += '<svg class="bi bi-bell" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M8 16a2 2 0 002-2H6a2 2 0 002 2z"/><path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 004 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 00-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 111.99 0A5.002 5.002 0 0113 6c0 .88.32 4.2 1.22 6z" clip-rule="evenodd"/></svg>';
    }
    else
    {
        return '';

    }
    result += '</a></li>';
    return result;
}

function updateNotificationToRead() {
    $.ajax({
        url: "?action=aUpdateNotificationToRead",
        type: "get"
    })
    .done(function (response, textStatus, jqXHR) {
        //$('#navigation-link').html(formatNotificationBell(response));
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
        console.log("done");
    });
}