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