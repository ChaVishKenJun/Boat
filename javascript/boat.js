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
    if ($('#userIds').val() != '') {
        $('#userIds').val($('#userIds').val() + ',');
    }
    
    if (!($('#userIds').val()).split(',').includes(id)) {
        $('#userIds').val($('#userIds').val() + id);

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