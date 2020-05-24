/* CONSTANT VARIABLES */
const newGroupLi = '<li class="nav-item">' + 
    '<a class="nav-link active" href="#" data-toggle="modal" data-target="#exampleModalCenter">' + 
        '<svg class="bi bi-plus-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
            '<path fill-rule="evenodd" d="M8 3.5a.5.5 0 01.5.5v4a.5.5 0 01-.5.5H4a.5.5 0 010-1h3.5V4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>' + 
            '<path fill-rule="evenodd" d="M7.5 8a.5.5 0 01.5-.5h4a.5.5 0 010 1H8.5V12a.5.5 0 01-1 0V8z" clip-rule="evenodd"/>' + 
            '<path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>' + 
        '</svg>' + 
        '&nbsp;' +
        '<span>New group</span>' + 
    '</a>' + 
'</li>';

const sentSvg = '<svg class="bi bi-check float-right" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' + 
    '<path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"/>' + 
'</svg>';

const readSvg = '<svg class="bi bi-check-all float-right" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' + 
    '<path fill-rule="evenodd" d="M12.354 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"/>' + 
    '<path d="M6.25 8.043l-.896-.897a.5.5 0 10-.708.708l.897.896.707-.707zm1 2.414l.896.897a.5.5 0 00.708 0l7-7a.5.5 0 00-.708-.708L8.5 10.293l-.543-.543-.707.707z"/>' + 
'</svg>';

/* GLOBAL VARIABLES */
var dataLoader; // Interval object for polling data
var lastMessageId = 0;
var updateTimestamp = null;
var mentionedUsers = [];
var currentGroupId = 0;

function toDateString(datetime) {
    let string ='';

    string += datetime.getFullYear() + '-';
    string += ("0" + (datetime.getMonth() + 1)).slice(-2) + '-';
    string += ("0" + datetime.getDate()).slice(-2) + ' ';

    string += ("0" + datetime.getHours()).slice(-2) + ':';
    string += ("0" + datetime.getMinutes()).slice(-2) + ':';
    string += ("0" + datetime.getSeconds()).slice(-2) + '.';
    string += datetime.getMilliseconds() + '000';

    return string;
}

/* VIEW RELATED FUNCTIONS */
function scrollDown() {
    $("html, body").scrollTop($(document).height());
}

function adjustView() {
    const size = $('#sizer').find('div:visible').data('size');
    if (size == 'sm' || size == 'xs') {
        $('#openSidebarButton').show();
        $('.sidebar').hide();
    } else {
        $('#openSidebarButton').hide();
        $(".sidebar").show();
    }
}

$(window).resize(function() {
    adjustView();
});

$('#openSidebarButton').click(function () {
    $('.sidebar').animate({width:'toggle'}, 350);
});

$(document).ready(function () {
    adjustView();

    // Load groups
    loadGroups();
    
    // Load groups every second
    setInterval(loadGroups, 1000);

    $('body').popover({
        placement: 'bottom',
        html: true,
        content: function () {
            var messageId = $(this).parent().parent().parent().attr('message-id');
            var data = $(this).parent().children('span').children('span').html();
            var div = $('<div></div>');
            div.append('<button type="button" class="btn btn-block" data-toggle="modal" data-target="#editMessageModal" id="editMessageButton" onclick="editMessage(' + messageId + ')">Edit</svg></button>');
            div.append('<button type="button" class="btn btn-block" onclick="pinMessage(' + messageId + ')">Pin</button>');
            div.append('<button type="button" class="btn btn-block" onclick="deleteMessage(' + messageId + ')">Delete</button>');
            return div;
        },
        container: 'body',
        selector: '.message-button', // Sepcify the selector here 
        trigger: 'focus'
    });
        
    $(function () {
        $('[data-toggle="popover"]').popover({
            placement: 'top',
            html: true,
            content: function () {
                var div = $('<div></div>');
                div.append('<button type="button" class="btn btn-outline-dark m-1" data-toggle="modal" data-target="#uploadVideoModal"><svg class="bi bi-camera-video" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.667 3.5c-.645 0-1.167.522-1.167 1.167v6.666c0 .645.522 1.167 1.167 1.167h6.666c.645 0 1.167-.522 1.167-1.167V4.667c0-.645-.522-1.167-1.167-1.167H2.667zM.5 4.667C.5 3.47 1.47 2.5 2.667 2.5h6.666c1.197 0 2.167.97 2.167 2.167v6.666c0 1.197-.97 2.167-2.167 2.167H2.667A2.167 2.167 0 01.5 11.333V4.667z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M11.25 5.65l2.768-1.605a.318.318 0 01.482.263v7.384c0 .228-.26.393-.482.264l-2.767-1.605-.502.865 2.767 1.605c.859.498 1.984-.095 1.984-1.129V4.308c0-1.033-1.125-1.626-1.984-1.128L10.75 4.785l.502.865z" clip-rule="evenodd"/></svg></button>');
                div.append('<button type="button" class="btn btn-outline-dark m-1" data-toggle="modal" data-target="#uploadImageModal"><svg class="bi bi-card-image" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5zm-13-1A1.5 1.5 0 000 3.5v9A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0014.5 2h-13z" clip-rule="evenodd"/><path d="M10.648 7.646a.5.5 0 01.577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 01.63-.062l2.66 1.773 3.71-3.71z"/><path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"/></svg></button>');
                div.append('<button type="button" class="btn btn-outline-dark m-1" data-toggle="modal" data-target="#newPollModal"><svg class="bi bi-list-check" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zm0-4a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zm0-4a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zM3.854 2.146a.5.5 0 010 .708l-1.5 1.5a.5.5 0 01-.708 0l-.5-.5a.5.5 0 11.708-.708L2 3.293l1.146-1.147a.5.5 0 01.708 0zm0 4a.5.5 0 010 .708l-1.5 1.5a.5.5 0 01-.708 0l-.5-.5a.5.5 0 11.708-.708L2 7.293l1.146-1.147a.5.5 0 01.708 0zm0 4a.5.5 0 010 .708l-1.5 1.5a.5.5 0 01-.708 0l-.5-.5a.5.5 0 01.708-.708l.146.147 1.146-1.147a.5.5 0 01.708 0z" clip-rule="evenodd"/></svg></button>');
                return div;
            },
            container: 'body',
            trigger: 'focus'
        });
    });

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
                    
                }
            };
            xmlhttp.open("GET", "?action=aQueryUser&query=" + query, true);
            xmlhttp.send();
        } else {
            $('.dropdown').remove();
        }
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

    $('input[type="file"]').on('change', updateLabel);

    $('#newGroupForm').on('submit', submitNewGroup);
});

/* ----------------------------------------------------- GROUP ----------------------------------------------------- */

/* ---------------------------------------------------- CREATE ---------------------------------------------------- */

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

/* ----------------------------------------------------- READ ----------------------------------------------------- */

function loadGroups() {
    $.ajax({
        url: "?action=aLoadGroups",
        type: "get"
    })
    .done(function (response, textStatus, jqXHR) {
        let html = newGroupLi;

        try {
            var groups = JSON.parse(response);

            groups.forEach(group => {
                html += '<li class="nav-item">';
                html += '<a class="nav-link' + (group['id'] == currentGroupId ? " active" : "") + '" href="#" group-id="' + group['id'] + '" onclick=openGroup(this)>';
                html += '<span>' + group['name'] + '</span>';
                html += '</a>';
                html += '</li>';
            });
        } catch (e) {
            console.log("Invalid JSON: " + response);
        }

        $('.nav').html(html);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("An error occured while loading groups: " + textStatus + errorThrown);
        $('.nav').html("An error has occured. Please try again later.");
    })
}

function openGroup(sender) {
    clearInterval(dataLoader);

    var groupId = $(sender).attr('group-id');

    currentGroupId = groupId;

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
    updateTimestamp = new Date();
}

function pollData() {
    /// <summary>Check for newly created data and update the content.</summary>
    loadMessages(lastMessageId);
    updateMessages(updateTimestamp);
}

function loadMessages(after = 0) {
    $.ajax({
        url: "?action=aLoadMessages" + (after != 0 ? "&after=" + after : ''),
        type: "get"
    })
    .done(function (response, textStatus, jqXHR) {
        if (after == 0) {
            if (response != '') {
                $('#messages').html(formatMessages(response));       
                
                $($('.message')[0]).css('margin-top', $('#pinnedMessage').innerHeight())

                scrollDown();
                loadImages();
                loadVideos();
            } else {
                $('#messages').html('This chat is still new.');
            }
        } else {
            if (response != '') {
                $('#messages').append(formatMessages(response));

                $($('.message')[0]).css('margin-top', $('#pinnedMessage').innerHeight())

                scrollDown();
                loadImages();
                loadVideos();
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
        
        if (message.pinnedDate != null && message.deletedDate == null)
        {
            result += '<div id="pinnedMessage" message-id="' + message.messageId + '" class="text-white bg-primary mb-3 ml-md-auto col-lg-10 col-md-9 col-12 px-4 py-2 fixed-top">';
            result += '<div>'
            result += '<div>'
            switch (message.type) {
                case "text":
                    result += message.data;
                    break;
                case "image":
                    result += "<div class='image bg-light px-3 py-1 m-1 rounded'></div>";
                    break;
                case "video":
                    result += "<div class='video bg-light px-3 py-1 m-1 rounded'></div>";
                    break;
                case "poll":
                    result += "<div class='poll bg-light px-3 py-1 m-1 rounded'>";
                    result += formatPoll(message);  
            result += '</div>';
            break;
                default:
                    break;
            }
            result += '</div>';
            result += '</div>';
            result += '</div>';
        }

        result += "<div message-id='" + message.messageId + "' class='message container-fluid align-text-bottom'>";

        if (!message.isMine) {
            result += "<div class='row user-row'>";
            result += "<div class='col'>";
            result += "<span class='user'>" + message.userFirstName + ' ' + message.userLastName + "</span>";
            result += "</div>";
            result += "</div>";
        }    

        result += "<div class='row content-row'>";
        result += "<div class='col position-relative'>";             

        if(message.deletedDate == null)
        {
            if(message.isMine)
            {
                result += renderMessageButton();  
            }               

            switch (message.type) {
                case "text":
                    result += renderTextMessage(message.data, message.isMine);
                    break;
                case "image":
                    result += "<div class='d-inline-block image bg-light px-3 py-1 m-1 rounded" + (message.isMine ? " float-right" : " float-left") + "'></div>";
                    break;
                case "video":
                    result += "<div class='d-inline-block video bg-light px-3 py-1 m-1 rounded" + (message.isMine ? " float-right" : " float-left") + "'></div>";
                    break;
                case "poll":    
                    result += "<div class='poll bg-light px-3 py-1 m-1 rounded" + (message.isMine ? " float-right" : " float-left") + "'>";
                    result += formatPoll(message);    
                    result += "</div>";
                    break;
                default:
                    break;
            }            
        } else {
            result += renderDeleteMessage(message.isMine);
        }
        
        result += "</div>";
        result += "</div>";

        if(message.deletedDate == null && message.editedDate != null) {
            result += renderEditedMessage(message.isMine);
        }
    
        result += "<div class='row mb-2 date-row'>"
        result += "<div class='col'>";
        // Tracking message
        if (message.isMine)
        {
            if (message.readDate == null) {
                result += sentSvg;
            } else {
                result += readSvg;
            }            
        } 
        // Date
        result += "<span class='date badge text-muted font-weight-light" + (message.isMine ? " float-right" : "") + "'>" + message.date.split('.')[0] + "</span>";
        result += "</span>";         
        result += "</div>";
        result += "</div>";
        result += "</div>";

        lastMessageId = message.messageId;
    });
    
    return result;
}

function formatPoll(message){
    result = '';

    const endButtonHtml = "<a class='btn btn-primary btn-sm btn-block text-white mb-1' onclick='return endPoll(" + message.messageId + ");'>End</a>";
    if (message.data.endedDate != null) {
        result += "<h5 class='text-dark text-center mt-1'>" + message.data.title + "</h5>";
        result += formatPollResult(message.data.result);
    } else {
        if (message.data.voted == '1') {
            result += "<h5 class='text-dark text-center mt-1'>" + message.data.title + "</h5>";
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
            result += "<h5 class='text-dark text-center mt-1'>" + message.data.title + "</h5>";

            if (message.data.due != null) {
                result += "<div class='text-center font-weight-lighter mb-1'><small>Due: " + message.data.due + "</small></div>";
            }

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

            result += "<button class='btn btn-primary btn-sm btn-block mb-2' type='submit'>Vote</button>";

            if (message.isMine) {
                result += endButtonHtml;
            }

            result += "</fieldset>";
            result += "</form>";
        }
    }
    return result;
}

function updateMessages(updatedLaterThan) {
    $.ajax({
        url: "?action=aGetUpdatedMessages&updatedLaterThan=" + toDateString(updatedLaterThan),
        type: "get"
    })
    .done(function (response, textStatus, jqXHR) {
        if (response != '[]') {
            try {
                updates = JSON.parse(response);
                
                updates.forEach(update => {
                    const message = $('.message[message-id=' + update.id + ']');
                    if (message.length > 0) {
                        switch (update.change) {
                            case 'edit':
                                switch (update.type) {
                                    case 'text':
                                        var container = $(message).find('.content-row').find('.col');
                                        var isMine = $(message).find('.float-right').length > 0;
                                        container.html(renderTextMessage(update.content, isMine));

                                        if ($(message).find('.meta-row').length == 0) {
                                            $(message).find('.content-row').after(renderEditedMessage(isMine));
                                        }

                                        break;
                                    default:
                                        // TODO: Implement other types when they are editable.
                                        break;
                                }
                                break;
                            case 'delete':
                                var container = $(message).find('.content-row').find('.col');
                                var isMine = $(message).find('.float-right').length > 0;
                                container.html(renderDeleteMessage(isMine));
                                $(message).find('.meta-row').remove();
                                break;
                            case 'pinned':
                                loadMessages();
                                break;
                            case 'read':
                                var container = $(message).find('.date-row').find('.col');
                                var isMine = $(message).find('.float-right').length > 0;

                                if (isMine) {
                                    container.find('svg').remove();
                                    container.html(readSvg + container.html());
                                }
                                break;
                            case 'ended':
                                loadMessages();
                                break;
                        }
                    }
                });
            } catch (e) {
                console.log("Invalid JSON: " + response);
            }
            
            updateTimestamp = new Date();
        }
    });
}

function sendMessage() {
    var message = $('#input').find('input').val();
    if (message != '') {
        $.ajax({
            url: "?action=aSendMessage",
            type: "get",
            data: { message : message, mentions: mentionedUsers.map(a => a.id) }
        })
        .done(function (response, textStatus, jqXHR) {
            $('#input').find('input').val('');
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("Error" + textStatus + errorThrown);
        })
    }
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
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("Error" + textStatus + errorThrown);
        })
        .always(function () {

        });
    } else {
    }
}

function pinMessage(messageId)
{
    $.ajax({
        url: "?action=aPinMessage",
        type: "post",
        data: { messageId : messageId }
    })
    .done(function (response, textStatus, jqXHR) {
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {

    });
}

$('#input input').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        sendMessage();
    }
});

function renderMessageButton() {
    return '<a tabindex="0" class="text-black message-button" data-trigger="focus" role="button" data-toggle="popover">' + 
        '<svg class="bi bi-three-dots-vertical" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' + 
            '<path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" clip-rule="evenodd"/>' + 
        '</svg>' + 
    '</a>';  
}

function renderEditedMessage(isMine) {
    return '<div class="row meta-row">' + 
        '<div class="col position-relative">' + 
            '<span ' + (isMine ? 'class="float-right"' : '') + '>' + 
                '<span class="data">Message edited</span>' + 
            '</span>' + 
        '</div>' + 
    '</div>';
}

function renderDeleteMessage(isMine) {
    return '<span class="' + (isMine ? ' float-right' : ' float-left') + '">' + 
        '<span class="data">Message deleted</span>' + 
    '</span>';
}

function renderTextMessage(text, isMine) {
    return (isMine ? renderMessageButton() : '') + 
    '<span class="bg-light px-3 py-1 m-1 rounded' + (isMine ? ' float-right' : ' float-left') + '">' + 
        '<span class="data">' + text + '</span>' + 
    '</span>';
}

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

function endPoll(messageId) {
    $.ajax({
        url: "?action=aEndPoll",
        type: "post",
        data: { messageId: messageId }
    })
    .done(function (response, textStatus, jqXHR) {
        if (response == "true") {
        } else if (response == "false") {
            // Not every member has participated. Ask user again.
            if (confirm('Not everyone in the group has voted yet. Do you still want to end the poll?')) {
                $.ajax({
                    url: "?action=aEndPoll",
                    type: "post",
                    data: { messageId: messageId , force: "true" }
                })
                .done(function (forceResponse, forceTextStatus, forceJqXHR) {
                })
                .fail(function (forceJqXHR, forceTextStatus, forceErrorThrown) {
                    console.log("Error" + textStatus + errorThrown);
                })
            }
        }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
}

function formatPollResult(pollResult) {
    let result = '';
    const max = Math.max.apply(Math, pollResult.map(function (item) { return item.count; }));
    if (max == 0) {
        result = "<div class='text-center mb-2'>No result to show</div>";
    } else {
        pollResult.sort((a,b) => (a.count < b.count) ? 1 : ((b.count < a.count) ? -1 : 0)); 

        pollResult.forEach(item => {
            let portion = item.count * 100 / max;
            result += '<div class="progress mb-2">';
            if (item.count != 0) {
                result += '<div class="progress-bar" role="progressbar" style="width: ' + portion + '%;" aria-valuenow="' + portion + '" aria-valuemin="0" aria-valuemax="100">' + item.name + ' (' + item.count + ')' + '</div>';
            } else {
                result += '<div class="progress-bar bg-light text-dark" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">' + item.name + ' (' + item.count + ')' + '</div>';
            }
            result += '</div>';
        });

        result += "<div class='mb-2'></div>"
    }
    return result;
}

function editMessage(messageId)
{
    var data = $('.message[message-id=' + messageId + ']').find('.content-row').find('span.data');
    
    if (data.length > 0) {
        $("#editMessageForm #messageId").val(messageId);
        $("#editMessageForm .modal-body #data").val(data.text());
    }
}

function submitEditMessage(e) {
    e.preventDefault();
    $.ajax({
        url: "?action=aEditMessage",
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

$('#messageInput').on('change paste keyup', function () {
    var textMessage = $(this).val();

    if(textMessage != "") {
        if (textMessage.includes("@")) {
            var query = textMessage.substr(textMessage.lastIndexOf("@") + 1);    
            if (query != "" && !query.includes(')')) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
        
                        var result = '';
                        result += '<div class="dropup">';
                        
                        result += '<div class="dropdown-menu" aria-labelledby="dropupMenuButton" style="display: inline; margin-top: -5px;">';
        
                        if (this.responseText != '') {
                            this.responseText.split('\\n').forEach(user => {
                                var fields = user.split(',');
                                result += '<a class="dropdown-item" style="cursor: pointer;" user-id=' + fields[0] + ' onclick=selectMentionUser(' + fields[0] + ",'" + fields[1] + "','" + fields[2] + "','" + fields[3] + "')>";
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
        
                        $('#messageInput').parent().prepend(result);
                        $('#dropupMenuButton').click();
                        
                    }
                };
                xmlhttp.open("GET", "?action=aQueryUserFromCurrentGroup&query=" + query, true);
                xmlhttp.send();
            } else {
                $('.dropup').remove();
            }
        } else {
            $('.dropup').remove();
        }

        // Update mentioned users
        var updatedUsers = [];
        var deletedUsers = [];

        mentionedUsers.forEach(user => {
            if (textMessage.includes(getUserString(user.firstname, user.lastname, user.email))) {
                updatedUsers.push(user);
            } else {
                deletedUsers.push(user);
            }
        });

        mentionedUsers = updatedUsers;

        if (deletedUsers.length > 0) {
            deletedUsers.forEach(user => {
                const userString = '@' + getUserString(user.firstname, user.lastname, user.email);
                $('#messageInput').val(textMessage.replace(userString.substring(0, userString.length - 1), ''));
            });
        }

    } else {
        $('.dropup').remove();
    }
      
});

function selectMentionUser(id, firstname, lastname, email) {   
    var textMessage = $('#messageInput').val().substr(0, $('#messageInput').val().lastIndexOf("@") +1);    
    $('#messageInput').val(textMessage + getUserString(firstname, lastname, email) + ' ');

    mentionedUsers.push({ 'id': id, 'firstname': firstname, 'lastname': lastname, 'email': email });

    $('.dropup').remove();    
}

function getUserString(firstname, lastname, email) {
    return firstname + " " + lastname + " " + '(' + email + ')';
}

/* ----------------------------------------------------- Media ----------------------------------------------------- */

function updateLabel() {
    let value = $(this).val();
    value = value.substr(value.lastIndexOf('\\') + 1);
    if (value !== '') {
        $('label[for="' + $(this).attr("id") + '"]').text(value);
    }
}

function sendImage(e) {
    e.preventDefault();

    const file = $(e.target).find('input[type="file"]').prop('files')[0];
    const form = new FormData();
    form.append('file', file);

    $.ajax({
        url: "?action=aSendImage",
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,                         
        type: 'post',
        data: form,
    })
    .done(function (response, textStatus, jqXHR) {
        if (response == 'true') {

        } else {
            
        }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
        $($($(e.target).parent().parent()).find('.close')).click();
    });
    return false;
}

function sendVideo(e) {
    e.preventDefault();

    const file = $(e.target).find('input[type="file"]').prop('files')[0];
    const form = new FormData();
    form.append('file', file);
    
    $.ajax({
        url: "?action=aSendVideo",
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,                         
        type: 'post',
        data: form,
    })
    .done(function (response, textStatus, jqXHR) {
        if (response == 'true') {

        } else {
            
        }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
        $($($(e.target).parent().parent()).find('.close')).click();
    });
    return false;
}

function loadImages() {
    $('.image').each(function () {
        if ($(this).find('img').length == 0) {
            const container = $(this);
            const id = container.parent().parent().parent().attr('message-id');
            
            $.ajax({
                url:'?action=aLoadImage',
                cache:false,
                data: { messageId: id }
            })
            .done(function (response, textStatus, errorThrown) {
                container.append('<img src="' + response + '"/>');
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("Error" + textStatus + errorThrown);
            })
            .always(function () {
            });
        }
    });
}

function loadVideos() {
    $('.video').each(function () {
        if ($(this).find('video').length == 0) {
            const container = $(this);
            const id = container.parent().parent().parent().attr('message-id');
            
            $.ajax({
                url:'?action=aLoadVideo',
                cache:false,
                data: { messageId: id }
            })
            .done(function (response, textStatus, errorThrown) {
                container.append('<video src="' + response + '" controls></video>');
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("Error" + textStatus + errorThrown);
            })
            .always(function () {
            });
        }
    });
}

function submitNewGroup(e) {
    e.preventDefault();

    $.ajax({
        url: "?action=aCreateGroup",
        type: "post",
        data: { data: JSON.stringify($(e.target).serializeArray()) }
    })
    .done(function (response, textStatus, jqXHR) {
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("Error" + textStatus + errorThrown);
    })
    .always(function () {
        $($($(e.target).parent().parent()).find('.close')).click();
    });
    return false;
}