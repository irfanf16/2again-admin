<div class="modal custom edit_photo" id="upload_capture_popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-basecolor1">
            <button type="button" class="btn-close circle" data-bs-dismiss="modal" aria-label="Close">
                <i class="fal icon-cross-circle"></i>
            </button>
            <div class="modal-body text-center">
                <h1 class="mb-3">Upload Photo</h1>
                <div class="camera-section">
                    <div id="camera-box">
                        <div class="camera">
                            <div id="my_camera">
                            </div>
                            <ul class="icon-circle" id="icon-circle">
                                <li>
                                    <a class="btn circle btn-danger">
                                        <i class="fal icon-face"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="btn circle btn-danger">
                                        <i class="fal icon-sun"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="pre_take_buttons" class="btn-group space-between">
                            <button type="button" onClick="preview_snapshot()" class="btn w-100">Start Capture</button>
                        </div>
                        <div id="post_take_buttons" style="display:none" class="btn-group space-between">
                            <button type="button" onClick="cancel_preview()" class="btn btn-orange"><i class="icon-retake"></i>Retake</button>
                            <button type="button" onClick="save_photo()" class="btn btn-yellow" ><i class="icon-check-circle"></i>Save</button>
                        </div>
                    </div>

                    <div id="results" style="display:none">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
