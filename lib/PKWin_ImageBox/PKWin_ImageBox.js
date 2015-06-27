jQuery(document).ready(function () {
    PKWin_ImageBox._prepare();
});

window.PKWin_ImageBox = {
    _actualImageId: -1,
    _ajaxLoader: null,
    _imageCollection: new Array(),
    _globalFunctions: {
        _isUrl: function (urlCandidate) {
            var pattern = new RegExp('^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*(\\?[;&a-z\\d%_.~+=-]*)?(\\#[-a-z\\d_]*)?$', 'i');
            if (!pattern.test(urlCandidate)) {
                if (urlCandidate.indexOf(' ') == -1 && urlCandidate.indexOf('/') == 0) {
                    return true;
                }
                return false;
            }
            else
                return true;
        },
        _getRandomNumber: function (min, max) {
            if (min === undefined)
                min = 1000;
            if (max === undefined)
                max = 10000;
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },
        _getRatio: function (_pr_changed, _pr_newValue, _pr_width, _pr_height) {
            if (_pr_changed == "width") {
                if ((_pr_width / _pr_height) > 0) {
                    var _pr_value = _pr_width / _pr_height;
                    _pr_value = _pr_newValue / _pr_value;
                    return _pr_value;
                }
                else {
                    return _pr_newValue;
                }
            }
            else if (_pr_changed == "height") {
                var _pr_value = _pr_width / _pr_height;
                _pr_value = _pr_newValue * _pr_value;
                return _pr_value;
            }
            return 0;
        },
        _getWindowSize: function () {
            var _pr_width = 0;
            var _pr_height = 0;
            if (document.body && document.body.offsetWidth) { _pr_width = document.body.offsetWidth; }
            if (document.compatMode == 'CSS1Compat' && document.documentElement && document.documentElement.offsetWidth)
            { _pr_width = document.documentElement.offsetWidth; }
            if (window.innerWidth && window.innerHeight) { _pr_width = window.innerWidth; }
            if (document.body && document.body.offsetWidth) { _pr_height = document.body.offsetHeight; }
            if (document.compatMode == 'CSS1Compat' && document.documentElement && document.documentElement.offsetWidth)
            { _pr_height = document.documentElement.offsetHeight; }
            if (window.innerWidth && window.innerHeight) { _pr_height = window.innerHeight; }
            return { _width: _pr_width, _height: _pr_height };
        },
        _getImagesInGroup: function (groupName) {
            return jQuery.grep(PKWin_ImageBox._imageCollection,
                   function (o, i) { return o._data._group === groupName; },
            false);
        },
        _getRankInGroup: function (group, id) {
            var _pr_i = 0;
            for (_pr_i = 0; _pr_i < group.length; _pr_i++) {
                if (id == group[_pr_i]._data._number)
                    return _pr_i;
            }
            return -1;
        },
        _getUniqueId: function (bef, aft) {
            var _pr_id = Math.random().toString(36).substring(7);
            if (jQuery('#' + bef + _pr_id + aft).length > 0) {
                return PKWin_ImageBox._globalFunctions._getUniqueId(bef, aft);
            }
            return bef + _pr_id + aft;
        },
        _encode64: function (inputStr) {
            var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
            var outputStr = "";
            var i = 0;

            while (i < inputStr.length) {
                var byte1 = inputStr.charCodeAt(i++) & 0xff;
                var byte2 = inputStr.charCodeAt(i++) & 0xff;
                var byte3 = inputStr.charCodeAt(i++) & 0xff;
                var enc1 = byte1 >> 2;
                var enc2 = ((byte1 & 3) << 4) | (byte2 >> 4);
                var enc3, enc4;
                if (isNaN(byte2)) {
                    enc3 = enc4 = 64;
                }
                else {
                    enc3 = ((byte2 & 15) << 2) | (byte3 >> 6);
                    if (isNaN(byte3)) {
                        enc4 = 64;
                    }
                    else {
                        enc4 = byte3 & 63;
                    }
                }
                outputStr += b64.charAt(enc1) + b64.charAt(enc2) + b64.charAt(enc3) + b64.charAt(enc4);
            }
            return outputStr;
        }
    },
    _drawingFunctions: {
        _createScene: function () {
            PKWin_ImageBox._drawingFunctions._deleteScene();
            var windowSize = PKWin_ImageBox._globalFunctions._getWindowSize();
            jQuery("body").append(jQuery('<div class="PKWinImageBox_mask" style="width:' + windowSize._width + 'px; height:' + windowSize._height + 'px;"></div>'));
            jQuery("body").append(jQuery('<div class="PKWinImageBox_content" style="width:' + (windowSize._width - 20) + 'px; height:' + windowSize._height + 'px;"></div>'));
            
            jQuery(".PKWinImageBox_content").append(jQuery('<div class="bt_close"></div><div class="loader"></div>'));
            jQuery(".PKWinImageBox_content").append(jQuery('<div class="count"></div>'));
            jQuery(".PKWinImageBox_content").append(jQuery('<div class="info"><div class="close"></div><h1></h1><h2></h2></div>'));
            jQuery(".PKWinImageBox_content > .info > .close").click(function () { PKWin_ImageBox._drawingFunctions._hideInfo(); });
            jQuery(".PKWinImageBox_content > .bt_close").click(function () { PKWin_ImageBox._drawingFunctions._deleteScene(); });

            //--- Pozice je absolute a ne fixed hlavně kvůli dotikovým zařízením, aby se mohla fotka přiblížit
            jQuery(".PKWinImageBox_content").css("top", jQuery(window).scrollTop() + "px");
            if (PKWin_ImageBox._imageCollection.length > 1) {
                jQuery(".PKWinImageBox_content").append(jQuery('<div class="bt_left"></div><div class="bt_right"></div>'));
                jQuery(".PKWinImageBox_content > .bt_left").click(function () { PKWin_ImageBox._drawingFunctions._changeFoto("prev"); });
                jQuery(".PKWinImageBox_content > .bt_right").click(function () { PKWin_ImageBox._drawingFunctions._changeFoto("next"); });
            }
        },
        _deleteScene: function () {
            PKWin_ImageBox._actualImageId = -1;
            jQuery(".PKWinImageBox_content").remove();
            jQuery(".PKWinImageBox_mask").remove();
        },
        _recalculateScene: function () {
            var _pr_windowSize = PKWin_ImageBox._globalFunctions._getWindowSize();
            jQuery(".PKWinImageBox_mask").css("width", _pr_windowSize._width + "px").css("height", _pr_windowSize._height + "px");
            jQuery(".PKWinImageBox_content").css("width", _pr_windowSize._width - 20 + "px").css("height", _pr_windowSize._height + "px");

            PKWin_ImageBox._imageCollection[PKWin_ImageBox._actualImageId]._setSize();
            PKWin_ImageBox._imageCollection[PKWin_ImageBox._actualImageId]._centerImage();
        },
        _changeFoto: function (_prevNext) {
            var _pr_imagesInGroup = PKWin_ImageBox._globalFunctions._getImagesInGroup(PKWin_ImageBox._imageCollection[PKWin_ImageBox._actualImageId]._data._group);
            var _pr_rankInGroup = PKWin_ImageBox._globalFunctions._getRankInGroup(_pr_imagesInGroup, PKWin_ImageBox._actualImageId);
            if (_prevNext == "next") {
                _prevNext = _pr_rankInGroup + 1;
                if (_prevNext >= _pr_imagesInGroup.length)
                    _prevNext = 0;
            }
            else if (_prevNext == "prev") {
                _prevNext = _pr_rankInGroup - 1;
                if (_prevNext < 0)
                    _prevNext = _pr_imagesInGroup.length - 1;
            }
            _pr_imagesInGroup[_prevNext]._show();
        },
        _showInfo: function () {
            if (PKWin_ImageBox._imageCollection[PKWin_ImageBox._actualImageId]._data._title != '' || PKWin_ImageBox._imageCollection[PKWin_ImageBox._actualImageId]._data._alt != '') {
                jQuery('.PKWinImageBox_content > .info > H1').html(PKWin_ImageBox._imageCollection[PKWin_ImageBox._actualImageId]._data._title);
                jQuery('.PKWinImageBox_content > .info > H2').html(PKWin_ImageBox._imageCollection[PKWin_ImageBox._actualImageId]._data._alt);
                jQuery('.PKWinImageBox_content > .info').css({ display: 'block', left: (jQuery('.PKWinImageBox_content > .info').outerWidth() * -1) + 'px' }).animate({ left: '0px' }, 500);
            }
        },
        _hideInfo: function () {
            jQuery('.PKWinImageBox_content > .info').animate({ left: (jQuery('.PKWinImageBox_content > .info').outerWidth() * -1) + 'px' }, 1000, function () {
                jQuery(this).css({ display: 'none' });
            });
        }
    },
    _prepare: function () {
        jQuery(window).resize(function () {
            if (PKWin_ImageBox._actualImageId > -1) {
                PKWin_ImageBox._drawingFunctions._recalculateScene();
            }
        });
        jQuery(document).keyup(function (e) {
            if (PKWin_ImageBox._actualImageId > -1) {
                switch (e.keyCode) {
                    case 27:
                        PKWin_ImageBox._drawingFunctions._deleteScene();
                        break;
                    case 37:
                        PKWin_ImageBox._drawingFunctions._changeFoto('prev');
                        break;
                    case 39:
                        PKWin_ImageBox._drawingFunctions._changeFoto('next');
                        break;
                    default: break;
                }
            }
        });
        jQuery(".PKWin_ImageBox").each(function (i) {
            if (jQuery(this).attr("id") === undefined) {
                jQuery(this).attr("id", PKWin_ImageBox._globalFunctions._getUniqueId('PKWin_ImageBox_Target_', ''));
            }
            jQuery(this).click(function (event) {
                event.preventDefault();
                PKWin_ImageBox._drawingFunctions._createScene();
                PKWin_ImageBox._imageCollection[i]._show();
            });
            PKWin_ImageBox._imageCollection[PKWin_ImageBox._imageCollection.length] = new PKWin_ImageBox.Foto({ _img_reference: jQuery(this), _id: jQuery(this).attr("id"), _number: i, _path: jQuery(this).attr("href"), _title: jQuery(this).children().attr('title'), _alt: jQuery(this).children().attr('alt'), _group: jQuery(this).attr("data-group") });
        });
    },
    Foto: function (data) {
        var self = this;
        this._data = jQuery.extend(
        {
            _img_reference: null,
            _id: null,
            _number: 0,
            _path: null,
            _img: null,
            _loaded: false,
            _name: '',
            _title: '',
            _alt: '',
            _group: 'PKWin_ImageBox_default',
            _originalSize: { _height: 0, _width: 0 },
            _canConvertToBase64: false
        }, data);

        this._show = function () {
            var _pr_imagesInGroup = PKWin_ImageBox._globalFunctions._getImagesInGroup(self._data._group);
            if (_pr_imagesInGroup.length > 1) {
                jQuery(".PKWinImageBox_content").find(".count").css("display", "block");
                jQuery(".PKWinImageBox_content").find(".bt_left").css("display", "block");
                jQuery(".PKWinImageBox_content").find(".bt_right").css("display", "block");
                jQuery(".PKWinImageBox_content").find(".count").text((PKWin_ImageBox._globalFunctions._getRankInGroup(_pr_imagesInGroup, self._data._number) + 1) + " / " + _pr_imagesInGroup.length);
            }
            else {
                jQuery(".PKWinImageBox_content").find(".count").css("display", "none");
                jQuery(".PKWinImageBox_content").find(".bt_left").css("display", "none");
                jQuery(".PKWinImageBox_content").find(".bt_right").css("display", "none");
            }

            jQuery(".PKWinImageBox_content > .loader").css("display", "block").text("");
            PKWin_ImageBox._drawingFunctions._hideInfo();
            jQuery("#PKWinImageBox_foto").remove();
            if (PKWin_ImageBox._ajaxLoader !== null) {
                //--- toto zamezí tomu, aby načítalo více fotografií najednou
                PKWin_ImageBox._ajaxLoader.abort();
            }
            PKWin_ImageBox._ajaxLoader = jQuery.ajax({
                xhr: function () {
                    var xhr = null;
                    xhr = new XMLHttpRequest();
                    if (xhr.addEventListener) { //--- IE 8 a nižší tuto vlastnost nemá
                        xhr.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable)
                            { jQuery(".PKWinImageBox_content > .loader").text(Math.round((evt.loaded / evt.total) * 100) + '%'); }
                        }, false);
                    }
                    return xhr;
                },
                type: "GET",
                crossDomain: true,
                url: self._data._path,
                complete: function (xhr, stat) {
                    self._draw(xhr.responseText);
                    //console.log(xhr.getResponseHeader("content-type"));
                },
                error: function (data) {
                    //PKWin_ImageBox._drawingFunctions._deleteScene();
                }
            });
        }
        this._draw = function (data) {
            var drawSelf = this;
            var _imagePath = self._data._path;
            self._data._img = jQuery("<img/>")
            .attr('id', 'PKWinImageBox_foto')
            .css('visibility', 'hidden')
            .load(function () {
                PKWin_ImageBox._actualImageId = self._data._number;
                jQuery(".PKWinImageBox_content").append(self._data._img);
                //---Zapsani originalnich rozmeru fotografie
                self._data._originalSize = { _width: jQuery(self._data._img).width(), _height: jQuery(self._data._img).height() };
                self._setSize();
                self._centerImage();
                jQuery("#PKWinImageBox_foto")
                .css('opacity', '0')
                .css('visibility', 'visible')
                .animate({ opacity: 1 }, 1000, function () {
                    jQuery(".PKWinImageBox_content > .loader").css("display", "none");
                    PKWin_ImageBox._drawingFunctions._showInfo();
                });
            }).error(function () {
                //---Nepodarilo se nacist obrazek
                PKWin_ImageBox._drawingFunctions._deleteScene();
            }).attr('src', _imagePath);
        }
        this._setSize = function () {
            var _pr_MaxSize = PKWin_ImageBox._globalFunctions._getWindowSize();
            _pr_MaxSize = { _width: parseInt(_pr_MaxSize._width * 0.9), _height: parseInt(_pr_MaxSize._height * 0.90) };
            if (_pr_MaxSize._width > self._data._originalSize._width) {
                _pr_MaxSize._width = self._data._originalSize._width;
            }
            if (_pr_MaxSize._height > self._data._originalSize._height) {
                _pr_MaxSize._height = self._data._originalSize._height;
            }
            //---------------------------------------

            var _pr_newImageSize = { _width: self._data._originalSize._width, _height: self._data._originalSize._height };
            //zjištění originálních rozměrů fotografie
            if (_pr_newImageSize._width > _pr_MaxSize._width) {
                _pr_newImageSize._width = _pr_MaxSize._width;
                _pr_newImageSize._height = PKWin_ImageBox._globalFunctions._getRatio("width", _pr_newImageSize._width, jQuery(self._data._img).width(), jQuery(self._data._img).height());
                if (_pr_newImageSize._height > _pr_MaxSize._height) {
                    _pr_newImageSize._height = _pr_MaxSize._height;
                    _pr_newImageSize._width = PKWin_ImageBox._globalFunctions._getRatio("height", _pr_newImageSize._height, jQuery(self._data._img).width(), jQuery(self._data._img).height());
                }
            }
            else {
                if (_pr_newImageSize._height > _pr_MaxSize._height) {
                    _pr_newImageSize._height = _pr_MaxSize._height;
                    _pr_newImageSize._width = PKWin_ImageBox._globalFunctions._getRatio("height", _pr_newImageSize._height, jQuery(self._data._img).width(), jQuery(self._data._img).height());
                }
            }
            jQuery(self._data._img).attr({ width: _pr_newImageSize._width + 'px', height: _pr_newImageSize._height + 'px' });
        }
        this._centerImage = function () {
            jQuery(self._data._img).css({
                top: (((jQuery(self._data._img).height() - jQuery(self._data._img).parent().height()) / 2) * -1) + 'px',
                left: (((jQuery(self._data._img).width() - jQuery(self._data._img).parent().width()) / 2) * -1) + 'px'
            });
        }
    }
};