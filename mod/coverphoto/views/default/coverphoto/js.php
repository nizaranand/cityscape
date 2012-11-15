/**
 * Cover photo cropping
 */

elgg.provide('elgg.coverphotoCropper');

/**
 * Register the cover photo cropper.
 *
 * If the hidden inputs have the coordinates from a previous cropping, begin
 * the selection and preview with that displayed.
 */
elgg.coverphotoCropper.init = function() {
	var params = {
		selectionOpacity: 0,
		aspectRatio: '16:9',
		onSelectEnd: elgg.coverphotoCropper.selectChange,
		onSelectChange: elgg.coverphotoCropper.preview
	};

	if ($('input[name=x2]').val()) {
		params.x1 = $('input[name=x1]').val();
		params.x2 = $('input[name=x2]').val();
		params.y1 = $('input[name=y1]').val();
		params.y2 = $('input[name=y2]').val();
	}

	$('#coverphoto-cropper').imgAreaSelect(params);

	if ($('input[name=x2]').val()) {
		var ias = $('#coverphoto-cropper').imgAreaSelect({instance: true});
		var selection = ias.getSelection();
		elgg.coverphotoCropper.preview($('#coverphoto-cropper'), selection);
	}
};

/**
 * Handler for changing select area.
 *
 * @param {Object} reference to the image
 * @param {Object} imgareaselect selection object
 * @return void
 */
elgg.coverphotoCropper.preview = function(img, selection) {
	// catch for the first click on the image
	if (selection.width == 0 || selection.height == 0) {
		return;
	}

	var origWidth = $("#coverphoto-cropper").width();
	var origHeight = $("#coverphoto-cropper").height();
	var scaleX = 100 / selection.width;
	var scaleY = 100 / selection.height;
	$('#coverphoto-preview > img').css({
		width: Math.round(scaleX * origWidth) + 'px',
		height: Math.round(scaleY * origHeight) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
};

/**
 * Handler for updating the form inputs after select ends
 *
 * @param {Object} reference to the image
 * @param {Object} imgareaselect selection object
 * @return void
 */
elgg.coverphotoCropper.selectChange = function(img, selection) {
	$('input[name=x1]').val(selection.x1);
	$('input[name=x2]').val(selection.x2);
	$('input[name=y1]').val(selection.y1);
	$('input[name=y2]').val(selection.y2);
};

elgg.register_hook_handler('init', 'system', elgg.coverphotoCropper.init);
