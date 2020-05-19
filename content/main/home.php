<div id="messages" class="pt-3 pb-2 mb-5"></div>
<div id="input" class="card bg-light col-md-9 ml-sm-auto col-lg-10 px-4 py-2 fixed-bottom hidden" hidden>
	<form>
		<div class="form-row">
			<div class="col-10">
				<input type="text" class="form-control">
			</div>
			<div class="col-1">
				<a tabindex="0" class="btn btn-lg btn-secondary btn-block text-white" data-trigger="focus"  role="button" data-toggle="popover">+</a>
			</div>
			<div class="col-1">
				<button class="btn btn-primary btn-lg btn-block" type="submit" onclick=sendMessage(this)>Send</button>
			</div>
		</div>
	</form>
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