/* Check exist */
function isExist(ele) {
	return ele.length;
}

/* Check length */
function getLen(str) {
	return /^\s*$/.test(str) ? 0 : str.length;
}

/* Check match */
function isMatch(value_1, value_2) {
	var flag = false;

	if (value_1 == value_2) {
		flag = true;
	}

	return flag;
}

/* Check numberic */
function isNumeric(value) {
	return /^\d+$/.test(value);
}

/* Check letters and nums */
function isAlphaNum(str) {
	var pattern = /^[a-z0-9]+$/;
	return pattern.test(str);
}

/* Check email */
function isEmail(str) {
	// var pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	return pattern.test(str);
}

/* Check phone */
function isPhone(str) {
	var pattern = /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/;
	return pattern.test(str) && getLen(str) == 10 ? true : false;
}

/* Check decimal */
function isDecimal(numbs) {
	var pattern = /^\d{1,10}(\.\d{1,4})?$/;
	return pattern.test(numbs);
}

/* Check zero */
function isZero(numbs) {
	var pattern = /^((?!(0))[0-9].*)$/g;
	return !pattern.test(numbs);
}

/* Check date */
function isDate(str) {
	var pattern = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/;
	return pattern.test(str);
}

/* Check coordinates */
function isCoords(str) {
	var pattern = /^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/;
	return pattern.test(str);
}

/* Check url */
function isUrl(str) {
	var pattern =
		/^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/;
	return pattern.test(str);
}

/* Check url youtube */
function isYoutube(str) {
	var pattern =
		/https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube\.com\/watch\?)((?:[\w\d\-\_\=]+&amp;(?:amp;)?)*v(?:&lt;[A-Z]+&gt;)?=([0-9a-zA-Z\-\_]+))/i;
	return pattern.test(str);
}

/* Check fanpage */
function isFanpage(str) {
	var pattern = /^(https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/;
	return pattern.test(str);
}

/* Check number */
function isNumber(numbs) {
	var pattern = /^[0-9]+$/;
	return pattern.test(numbs);
}

/* HoldOn open */
function holdonOpen(
	theme = 'sk-circle',
	text = 'Vui lòng chờ...',
	backgroundColor = 'rgba(0,0,0,0.8)',
	textColor = 'white'
) {
	var options = {
		theme: theme,
		message: text,
		backgroundColor: backgroundColor,
		textColor: textColor
	};

	HoldOn.open(options);
}

/* HoldOn close */
function holdonClose() {
	HoldOn.close();
}

/* Get info file */
function infoFile(file, info = '') {
	var result = '';

	if (file[0].files[0]) {
		if (info == 'ext') {
			result = file[0].files[0]
				? file[0].files[0].name.substring(file[0].files[0].name.lastIndexOf('.') + 1)
				: '';
		} else if (info == 'size') {
			result = file[0].files[0] ? formatBytes(file[0].files[0].size) : 0;
		}
	}

	return result;
}

/* Check extension file */
function checkExtFile(extension, extensionMain) {
	var result = true;

	if (extension) {
		var count = 0;

		for (var i = 0; i < extensionMain.length; i++) {
			if (extensionMain[i] != extension) {
				count++;
			}
		}

		if (count == extensionMain.length) {
			result = false;
		}
	}

	return result;
}

/* formatBytes */
function formatBytes(bytes, decimals = 2) {
	if (bytes === 0) {
		return 0;
	}

	const k = 1024;
	const dm = decimals < 0 ? 0 : decimals;
	const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
	const i = Math.floor(Math.log(bytes) / Math.log(k));
	const result = [];
	result['numb'] = parseFloat((bytes / Math.pow(k, i)).toFixed(dm));
	result['numb'] = parseFloat((bytes / Math.pow(k, i)).toFixed(dm));
	if(sizes[i] == 'Bytes'){
		result['numb'] = result['numb'] / 1024 / 1024;
	}else if(sizes[i] == 'KB'){
		result['numb'] = result['numb'] / 1024;
	}else if(sizes[i] == 'MB'){
		result['numb'] = result['numb'];
	}else if(sizes[i] == 'GB'){
		result['numb'] = result['numb'] * 1024;
	}else if(sizes[i] == 'TB'){
		result['numb'] = result['numb'] * 1024 * 1024;
	}
	result['ext'] = sizes[i];

	return result;
}

/* Radndom */
function stringRandom(length) {
	var result = '';
	var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;

	for (var i = 0; i < length; i++) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}

	return result;
}

/* Max Datetime Picker */
function maxDate(element) {
	if (MAX_DATE) {
		$(element).datetimepicker({
			timepicker: false,
			format: 'd/m/Y',
			formatDate: 'd/m/Y',
			// minDate: '1950/01/01',
			maxDate: MAX_DATE
		});
	}
}

/* Min Datetime Picker */
function minDate(element) {
	if (MAX_DATE) {
		$(element).datetimepicker({
			timepicker: false,
			format: 'd/m/Y',
			formatDate: 'd/m/Y',
			minDate: MAX_DATE
			// maxDate: MAX_DATE
		});
	}
}

/* Reader image */
function readImage(inputFile, elementPhoto, allowSize) {
	if (inputFile[0].files[0]) {
		if (inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
			var size = parseInt(inputFile[0].files[0].size) / 1024;

			if (size <= 4096) {
				var reader = new FileReader();
				reader.onload = function (e) {
					if (allowSize) {
						var image = new Image();
						var widthOriginal, heightOriginal;
						var sizeAllow = allowSize.split('x');
						var widthAllow = parseInt(sizeAllow[0]);
						var heightAllow = parseInt(sizeAllow[1]);
						image.src = e.target.result;
						image.onload = function () {
							widthOriginal = parseInt(this.width);
							heightOriginal = parseInt(this.height);

							if (widthOriginal > widthAllow || heightOriginal > heightAllow) {
								notifyDialog(
									'Kích thước tối đa: <strong>Width: ' +
										widthAllow +
										'px - Height: ' +
										heightAllow +
										'px</strong>'
								);
								return false;
							} else {
								$(elementPhoto).attr('src', e.target.result);
							}
						};
					} else {
						$(elementPhoto).attr('src', e.target.result);
					}
				};

				reader.readAsDataURL(inputFile[0].files[0]);
			} else {
				notifyDialog('Dung lượng hình ảnh lớn. Dung lượng cho phép <= 4MB ~ 4096KB');
				return false;
			}
		} else {
			$(elementPhoto).attr('src', '');
			notifyDialog('Định dạng hình ảnh không hợp lệ');
			return false;
		}
	} else {
		$(elementPhoto).attr('src', '');
		return false;
	}
}

/* Photo zone */
function photoZone(eDrag, iDrag, eLoad, allowSize) {
	if ($(eDrag).length) {
		/* Drag over */
		$(eDrag).on('dragover', function () {
			$(this).addClass('drag-over');
			return false;
		});

		/* Drag leave */
		$(eDrag).on('dragleave', function () {
			$(this).removeClass('drag-over');
			return false;
		});

		/* Drop */
		$(eDrag).on('drop', function (e) {
			e.preventDefault();
			$(this).removeClass('drag-over');

			var lengthZone = e.originalEvent.dataTransfer.files.length;

			if (lengthZone == 1) {
				$(iDrag).prop('files', e.originalEvent.dataTransfer.files);
				readImage($(iDrag), eLoad, allowSize);
			} else if (lengthZone > 1) {
				notifyDialog('Bạn chỉ được chọn 1 hình ảnh để upload');
				return false;
			} else {
				notifyDialog('Dữ liệu không hợp lệ');
				return false;
			}
		});

		/* File zone */
		$(iDrag).change(function () {
			readImage($(this), eLoad, allowSize);
		});
	}
}

/* Change title */
function changeTitle(text) {
	text = text.toLowerCase();
	text = text.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
	text = text.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
	text = text.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
	text = text.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
	text = text.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
	text = text.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
	text = text.replace(/đ/gi, 'd');
	text = text.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
	text = text.replace(/ /gi, '-');
	text = text.replace(/\-\-\-\-\-/gi, '-');
	text = text.replace(/\-\-\-\-/gi, '-');
	text = text.replace(/\-\-\-/gi, '-');
	text = text.replace(/\-\-/gi, '-');
	text = '@' + text + '@';
	text = text.replace(/\@\-|\-\@|\@/gi, '');

	return text;
}
