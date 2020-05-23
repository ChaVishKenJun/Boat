<div id="messages" class="pt-3 pb-2 mb-5"></div>
<div id="input" class="card bg-light col-md-9 ml-sm-auto col-lg-10 px-4 py-2 fixed-bottom hidden" hidden>
    <div class="form-row">
        <div class="col-10">
            <input type="text" class="form-control" id="messageInput">
            <input type="hidden" id="mentionedUserIds">
        </div>
        <div class="col-1">
            <a tabindex="0" class="btn btn-lg btn-lsecondary btn-block text-white" role="button" data-toggle="popover">+</a>
        </div>
        <div class="col-1">
            <button class="btn btn-primary btn-lg btn-block" onclick=sendMessage()>Send</button>
        </div>
    </div>
</div>

<!-- Upload Media Modal -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalTitle" area-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageModalTitle">Upload Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadImageForm" onsubmit="return sendImage(event);">
                <div class="modal-body">
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="image" type="file" accept="image/*" class="custom-file-input" id="inputUploadImage" aria-describedby="inputUploadImageAddon">
                            <label class="custom-file-label" for="inputUploadImage">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="submit" id="inputUploadImageAddon">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadVideoModal" tabindex="-1" role="dialog" aria-labelledby="uploadVideoModalTitle" area-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadVideoModalTitle">Upload Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadVideoForm" onsubmit="return sendVideo(event);">
                <div class="modal-body">
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="video" type="file" accept="video/*" class="custom-file-input" id="inputUploadVideo" aria-describedby="inputUploadVideoAddon">
                            <label class="custom-file-label" for="inputUploadVideo">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="submit" id="inputUploadVideoAddon">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- New Poll Modal -->
<div class="modal fade" id="newPollModal" tabindex="-1" role="dialog" aria-labelledby="newPollModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPollModalTitle">New Poll</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newPollForm" onsubmit="return submitNewPoll(event);">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="newPollTitle">Title</label>
                        <input name="title" type="text" class="form-control" id="newPollTitle">
                    </div>
                    <div id="newPollOptions" class="form-group">
                        <label>Options</label>
                        <input name="option" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button onclick="addPollOption();" type="button" class="btn btn-light btn-block text-left">
                            <svg class="bi bi-plus-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16 8A8 8 0 110 8a8 8 0 0116 0zM8.5 4a.5.5 0 00-1 0v3.5H4a.5.5 0 000 1h3.5V12a.5.5 0 001 0V8.5H12a.5.5 0 000-1H8.5V4z" clip-rule="evenodd"/>
                            </svg>
                            More Option
                        </button>
                    </div>
                    <div class="form-group">
                        <label>
                            Due
                            <small>(optional)</small>
                        </label>
                        <div class="form-row">
                            <div class="col">
                                <input name="dueDate" type="date" class="form-control col" id="newPollDueDate">
                            </div>
                            <div class="col">
                                <input name="dueTime" type="time" class="form-control col" id="newPollDueTime">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <label class="col" for="newPollMultiselect">
                                Multi-select
                                <small>(optional)</small>
                            </label>
                            <input name="multiselect" class="col" type="checkbox" id="newPollMultiselect">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Message Modal -->
<div class="modal fade" id="editMessageModal" tabindex="-1" role="dialog" aria-labelledby="editMessageModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMessageModalTitle">Edit Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editMessageForm" onsubmit="return submitEditMessage(event);">
                <input type="hidden" id="messageId" name="messageId" value="">
                <div class="modal-body">
                    <input name="data" type="text" class="form-control" id="data">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>