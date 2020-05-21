var dataLoader; // Interval object for polling data
var timestamp; // Timestamp when the data is loaded last time

function toDateString(datetime) {
    return datetime.getFullYear().toString() + '-' + (datetime.getMonth() + 1).toString() + '-' + datetime.getDate().toString() + ' ' + datetime.getHours() + ':' + datetime.getMinutes() + ':' + datetime.getSeconds() + '.' + datetime.getMilliseconds() + '000';
}

function scrollDown() {
    $("html, body").scrollTop($(document).height());
}

$(document).ready(function () {
    var messagePopover = {
        placement: 'bottom',
        container: 'body',
        html: true,
        selector: '.message-button', //Sepcify the selector here
        content: function () {
            var messageId = $(this).parent().parent().parent().attr('message-id');
            var div = $('<div></div>');
                div.append('<button type="button" class="btn btn-block" data-toggle="modal" data-target="#newPollModal">Edit</svg></button>');
                div.append('<button type="button" class="btn btn-block">Pin</button>');
                div.append('<button type="button" class="btn btn-block" onclick="deleteMessage(' + messageId + ')">Delete</button>');
                return div;
        }
    }
    $('body').popover(messagePopover);


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
    
    $(function () {
        $('[data-toggle="popover"]').popover({
            placement: 'top',
            html: true,
            content: function () {
                var div = $('<div></div>');
                div.append('<button type="button" class="btn btn-outline-dark m-1"><svg class="bi bi-camera-video" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.667 3.5c-.645 0-1.167.522-1.167 1.167v6.666c0 .645.522 1.167 1.167 1.167h6.666c.645 0 1.167-.522 1.167-1.167V4.667c0-.645-.522-1.167-1.167-1.167H2.667zM.5 4.667C.5 3.47 1.47 2.5 2.667 2.5h6.666c1.197 0 2.167.97 2.167 2.167v6.666c0 1.197-.97 2.167-2.167 2.167H2.667A2.167 2.167 0 01.5 11.333V4.667z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M11.25 5.65l2.768-1.605a.318.318 0 01.482.263v7.384c0 .228-.26.393-.482.264l-2.767-1.605-.502.865 2.767 1.605c.859.498 1.984-.095 1.984-1.129V4.308c0-1.033-1.125-1.626-1.984-1.128L10.75 4.785l.502.865z" clip-rule="evenodd"/></svg></button>');
                div.append('<button type="button" class="btn btn-outline-dark m-1"><svg class="bi bi-card-image" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5zm-13-1A1.5 1.5 0 000 3.5v9A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0014.5 2h-13z" clip-rule="evenodd"/><path d="M10.648 7.646a.5.5 0 01.577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 01.63-.062l2.66 1.773 3.71-3.71z"/><path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"/></svg></button>');
                div.append('<button type="button" class="btn btn-outline-dark m-1" data-toggle="modal" data-target="#newPollModal"><svg class="bi bi-list-check" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zm0-4a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zm0-4a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zM3.854 2.146a.5.5 0 010 .708l-1.5 1.5a.5.5 0 01-.708 0l-.5-.5a.5.5 0 11.708-.708L2 3.293l1.146-1.147a.5.5 0 01.708 0zm0 4a.5.5 0 010 .708l-1.5 1.5a.5.5 0 01-.708 0l-.5-.5a.5.5 0 11.708-.708L2 7.293l1.146-1.147a.5.5 0 01.708 0zm0 4a.5.5 0 010 .708l-1.5 1.5a.5.5 0 01-.708 0l-.5-.5a.5.5 0 01.708-.708l.146.147 1.146-1.147a.5.5 0 01.708 0z" clip-rule="evenodd"/></svg></button>');
                return div;
            },
            container: 'body'
        });
    });
    
    $('.popover-dismiss').popover({
        trigger: 'focus'
    });

    //notifications
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //$('#notifications').html(this.responseText);
            
            loadNotifications();
            loader = setInterval(loadNotifications, 1000);
        }
    };    
    xmlhttp.open("GET", "?action=aLoadNotifications", true);
    xmlhttp.send();
    

    $('.popover-dismiss').popover({
        trigger: 'focus'
    });
});

/* ----------------------------------------------------- GROUP ----------------------------------------------------- */

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
    clearInterval(dataLoader);

    // When a group is opened, load the page.
    $(sender).parent().find('.nav-link').removeClass('active');
    $($(sender).parent().find('.nav-link')[0]).addClass('active');
    $(sender).addClass('active');

    var groupId = $(sender).attr('group-id');

    if (groupId != null) {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $('#input').removeAttr("hidden");
                loadData();
                dataLoader = setInterval(pollData, 1000);
            }
        };
        
        xmlhttp.open("GET", "?action=aOpenGroup&groupId=" + groupId, true);
        xmlhttp.send();
    }
}

function sendMessage() {
    var message = $('#input').find('input').val();

    if (message != '') {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;   
            }
        };
        
        xmlhttp.open("GET", '?action=aSendMessage&message=' + message, true);
        xmlhttp.send();
    }

    $('#input').find('input').val('');
}

function deleteMessage(messageId)
{
    if (confirm('Are you sure you want to delete this message?')) {
        $.ajax({
            url: "?action=aDeleteMessage",
            type: "post",
            data: { messageId : messageId }
        })
        .done(function (response, textStatus, jqXHR) {
            loadMessages();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("Error" + textStatus + errorThrown);
        })
        .always(function () {

        });
    } else {
    }
}

/* ------------------------------------------------- NOTIFICATIONS ------------------------------------------------- */

function loadNotifications() {
    $.ajax({
        url: "?action=aLoadNotifications",
        type: "get"
    })
    .done(function (response, textStatus, jqXHR) {
        $('#notifications').html(formatNotifications(response));
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
    });
}
    
function formatNotifications(rawMessages) {
    var result = '';
    var notificationBellIsRed = "false";
    if (rawMessages != "") {
        result += "<table class='table'>";
        result += "<tbody>";

        rawMessages.split('\\n').forEach(message => {
            var fields = message.split(',');
            result += "<tr>";
            result += "<td>" + fields[0] + "</td>";
            result += "<td>" + fields[1] + "</td>";
            result += "</tr>";

            if(fields[2] == 0)
            {
                notificationBellIsRed = "true";
            }
                //change to read
                //$db->updateNotificationsIsReadToRead($userId);
        });

        result += "</tbody>";
        result += "</table>";
    } else {
        result = "<div>No Notifications found.</div>";
    }
    $('#navigation-link').html(formatNotificationBell(notificationBellIsRed));
    return result;
}


function updateNotificationsToRead() {
    var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            }
        };
        
        xmlhttp.open("GET", '?action=aUpdateNotificationsToRead', true);
        xmlhttp.send();
}


function formatNotificationBell(hasNotifications) {
    // TODO: Pull messages down
    var result = '<li class="nav-item"><a class="nav-link" href="#" data-target="#notifcationModal" data-toggle="modal" onclick="updateNotificationsToRead()">';
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

/* ---------------------------------------------------- MESSAGE ---------------------------------------------------- */

function loadData() {
    /// <summary>Load data when page is newly open.</summary>
    loadMessages();
}

function pollData() {
    /// <summary>Check for newly created data and update the content.</summary>
    loadMessages(timestamp);
}

function loadMessages(laterThan = null) {
    timestamp = new Date();
    
    $.ajax({
        url: "?action=aLoadMessages" + (laterThan != null ? "&laterThan=" + toDateString(laterThan) : ''),
        type: "get"
    })
    .done(function (response, textStatus, jqXHR) {
        if (laterThan == null) {
            if (response != '') {
                $('#messages').html(formatMessages(response));
                scrollDown();
            } else {
                $('#messages').html('This chat is still new.');
            }
        } else {
            if (response != '') {
                $('#messages').append(formatMessages(response));
                scrollDown();
            }
        }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("An error occured while loading messages: " + textStatus + errorThrown);
        $('#messages').html("An error has occured. Please try again later.");
    })
    .always(function () {
    });
}

function formatMessages(rawMessage) {
    // TODO: Pull messages down
    var messages = JSON.parse(rawMessage);

    var result = '';

    messages.forEach(message => {
        result += "<div message-id='" + message.messageId + "' class='message container-fluid align-text-bottom'>";

        if (!message.isMine) {
            result += "<div class='row'>";
            result += "<div class='col'>";
            result += "<span class='user'>" + message.userFirstName + ' ' + message.userLastName + "</span>";
            result += "</div>";
            result += "</div>";
        }                   

        if(message.isDeleted == "0")
        {

            result += "<div class='row'>";
            result += "<div class='col position-relative'>";
            result += "<a tabindex='0' class='text-black message-button' data-trigger='focus' role='button' data-toggle='popover'>";
            result += '<svg class="bi bi-three-dots-vertical" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">';
            result += '<path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" clip-rule="evenodd"/>';
            result += '</svg>';
            result += '</a>';   

            switch (message.type) {
                case "text":
                    result += "<span class='bg-light px-3 py-1 m-1 rounded" + (message.isMine ? " float-right" : " float-left") + "'>";
                    result += "<span class='data'>" + message.data + "</span>";
                    result += "</span>";
                    break;
                case "image":
                    break;
                case "video":
                    break;
                case "poll":
                    const endButtonHtml = "<button class='btn btn-primary btn-sm btn-block mt-2 mb-1' onclick='return endPoll(this);'>End</button>";
    
                    result += "<div class='.container-sm bg-light px-3 py-1 m-1 rounded" + (message.isMine ? " float-right" : " float-left") + "'>";
    
                    if (message.data.isEnded == '1') {
                        result += "<h5 class='text-center mt-1'>" + message.data.title + "</h5>";
                        
                    } else {
                        if (message.data.voted == '1') {
                            result += "<h5 class='text-center mt-1'>" + message.data.title + "</h5>";
                            result += "<div class='row mt-2'>";
                            result += "<div class='col text-center text-success'>";
                            result += '<svg class="bi bi-check" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">';
                            result += '<path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"/>';
                            result += '</svg>';
                            result += "</div>";
                            result += "</div>";
                            result += "<div class='row'>";
                            result += "<div class='col text-center text-success'>";
                            result += '<span class="font-weight-light">You voted!</span>';
                            result += "</div>";
                            result += "</div>";
                            if (message.isMine) {
                                result += endButtonHtml;
                            }
                            
                        } else {
                            result += "<form onsubmit='return vote(event);'>";
                            result += "<fieldset>";
                            result += "<h5 class='text-center mt-1'>" + message.data.title + "</h5>";
            
                            if (message.data.multiselect == "1") {
                                for (let index = 0; index < message.data.options.length; index++) {
                                    const option = message.data.options[index];
                                    
                                    result += '<div class="input-group mb-3">';
                                    result += '<div class="input-group-prepend">';
                                    result += '<div class="input-group-text">';
                                    result += '<input name="' + message.messageId + '" type="checkbox" value="' + option.id + '" id="option' + option.id + '">';
                                    result += '</div>';
                                    result += '</div>';
                                    result += '<label class="form-control" for="option' + option.id +'">';
                                    result += option.name;
                                    result += '</label>';
                                    result += '</div>';
                                }
                            } else {
                                for (let index = 0; index < message.data.options.length; index++) {
                                    const option = message.data.options[index];
            
                                    result += '<div class="input-group mb-3">';
                                    result += '<div class="input-group-prepend">';
                                    result += '<div class="input-group-text">';
                                    result += '<input name="' + message.messageId + '"type="radio" id="radios' + message.messageId + '" value="' + option.id + '" checked>';
                                    result += '</div>';
                                    result += '</div>';
                                    result += '<label class="form-control" for="radios' + message.messageId + '">';
                                    result += option.name;
                                    result += '</label>';
                                    result += '</div>';
                                }
                            }
            
                            result += "<button class='btn btn-primary btn-sm btn-block' type='submit'>Vote</button>";
        
                            if (message.isMine) {
                                result += endButtonHtml;
                            }
        
                            result += "</fieldset>";
                            result += "</form>";
                        }
                    }
    
                    result += "</div>";
                    break;
                default:
                    break;
            }
            
        }else{
            result += "<span class='" + (message.isMine ? " float-right" : " float-left") + "'>";
            result += "<span class='data'>Message deleted</span>";
            result += "</span>";
        }
        

        result += "</div>";
        result += "</div>";
        result += "<div class='row mb-2'>"
        result += "<div class='col'>";
        result += "<span class='date badge text-muted font-weight-light" + (message.isMine ? " float-right" : "") + "'>" + message.date.split('.')[0] + "</span>";
        result += "</span>";
        result += "</div>";
        result += "</div>";
        result += "</div>";
    });
    
    return result;
}

$('#input input').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
        sendMessage();
    }
  });

/* ------------------------------------------------------ POLL ----------------------------------------------------- */

function addPollOption() {
    $('#newPollOptions').append('<input name="option" type="text" class="form-control" required>');
}

function submitNewPoll(e) {
    e.preventDefault();
    $.ajax({
        url: "?action=aCreatePoll",
        type: "post",
        data: { data: JSON.stringify($(e.target).serializeArray()) }
    })
    .done(function (response, textStatus, jqXHR) {
        alert(response);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
        $($($(e.target).parent().parent()).find('.close')).click();
    });
    return false;
}

function vote(e) {
    e.preventDefault();
    $.ajax({
        url: "?action=aVote",
        type: "post",
        data: { data: JSON.stringify($(e.target).serializeArray()) }
    })
    .done(function (response, textStatus, jqXHR) {
        loadMessages();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
        // Reload page?
    });
    return false;
}

function endPoll(sender) {
    $.ajax({
        url: "?action=aEndPoll",
        type: "post",
        data: { messageId: $(sender).parent().parent().parent().parent().attr('message-id') }
    })
    .done(function (response, textStatus, jqXHR) {
        if (response == "true") {    
            // Poll is successfully ended. Refresh the chat.
            loadMessages();
        } else if (response == "false") {
            // Not every member has participated. Ask user again.
            if (confirm('Not everyone in the group has voted yet. Do you still want to end the poll?')) {
                $.ajax({
                    url: "?action=aEndPoll",
                    type: "post",
                    data: { messageId: $(sender).parent().parent().parent().parent().attr('message-id'), force: "true" }
                })
                .done(function (forceResponse, forceTextStatus, forceJqXHR) {
                    if (forceResponse == "true") {    
                        // Poll is successfully ended. Refresh the chat.
                        loadMessages();
                    }
                })
            }
        }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
}