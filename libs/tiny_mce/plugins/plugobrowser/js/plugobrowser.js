tinyMCEPopup.requireLangPack();

var PlugoBrowser = {
  absoluteURL: false,
  hostname: 'http://' + window.location.host,
  ed: null,
  relativeUploadDir: '',
  insertMethod: 0,
  //as file/image with thumb/full image
  imgSelected: false,
  selectedFile: null,
  selectedDir: '/',
  closePopupDisabled: false,
  displayStyle: 0,
  isTested: false,
  resizeEnd: false,
  uploadResult: true,
  ratioLock_thumb: true,
  ratioLock_full: true,
  selectedRatio: null,

  //Basic functions
  encodeURIComponentNoSlash: function (str)
  {
    return encodeURIComponent(str).replace(new RegExp('%2F', 'g'), '/');
  },

  escapeHtml: function (html)
  {
    return html ? html.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;") : html;
  },

  escapeForParam: function (str)
  {
    return str.replace(new RegExp('\'', 'g'), "\\'");
  },

  isInt: function (x)
  {
    var y = parseInt(x);
    if (isNaN(y)) return false;
    return x == y && x.toString() == y.toString();
  },

  //Init browser
  init: function (ed)
  {
    this.ed = ed;

    this.resizeWindow();
    $(window).resize(this.resizeWindow);

    this.initTest();
  },

  resizeWindow: function ()
  {
    // Get some layout dimensions
    var win = $(window);
    var winW = win.width();
    var winH = win.height();

    if (PlugoBrowser.resizeEnd !== false) clearTimeout(PlugoBrowser.resizeEnd);
    PlugoBrowser.resizeEnd = setTimeout(PlugoBrowser.checkMinWindowSize, 200);

    var breadH = $('#breadcrumb').outerHeight();
    var sidebarW = $('#sidebar_wrap').outerWidth();

    // Set Explorer Height
    $('#sidebar_wrap, #wrap, #content_wrap').height(winH);
    $('#sidebar').height(winH - 2 * 35);
    $('#content').height(winH - breadH);

    $('#content_wrap').width(winW - sidebarW - 1);
    $('#directory_list').width($('#folder_wrap').innerWidth());

    PlugoBrowser.positionPopup();
  },

  checkMinWindowSize: function ()
  {
    var winW = window.outerWidth;
    var winH = window.outerHeight;

    if (winW < 700 || winH < 400) window.resizeTo(winW < 700 ? 700 : winW, winH < 400 ? 400 : winH);
  },

  showOverlay: function ()
  {
    $('#overlay').fadeTo(300, 0.6);
  },

  showPopup: function (data, type, title, sbmBtn_title, sbmBtn_action, bottomCont, width, closeAction)
  {
    var id = parseInt(new Date().getTime() / 1000, 10);
    var zIndex = 1000 + ($('.popup').length * 15);
    if (isNaN(width)) width = 600;

    $(document.body).append('<span class="popupOverlay" id="popupOverlay_' + id + '" onmouseup="PlugoBrowser.hidePopup(event, \'' + id + '\');" style="z-index: ' + zIndex + ';">&nbsp;</span><div class="popup" id="popup_' + id + '" style="visibility: hidden; width: ' + width + 'px; z-index: ' + (zIndex + 10) + ';"><div class="popup_wrapper' + (type ? ' popup-' + type : '') + '"><div class="popup_header">' + (title ? title : '') + '</div><div class="popup_content">' + data + '</div><div class="popup_bottom">' + (bottomCont ? '<div class="popup_bottomCont">' + bottomCont + '</div>' : '') + '<div class="popup_buttons clearfix">' + (sbmBtn_title && sbmBtn_action ? '<a href="#" onmouseup="' + sbmBtn_action + '" class="popup_insert" id="popup_actionBtn">' + sbmBtn_title + '</a>' : '') + '</div></div><a href="" class="popup_close" onclick="PlugoBrowser.hidePopup(event, \'' + id + '\');' + (closeAction ? closeAction + '; ' : '') + ' return false;" title="' + this.ed.getLang('plugobrowser_dlg.close', 'Close') + '">&nbsp;</a></div></div>');

    window.setTimeout('PlugoBrowser.positionPopup()', 50);

    return id;
  },

  positionPopup: function ()
  {
    var win = $(window);
    var winW = win.width();
    var winH = win.height();

    $('.popup').each(function ()
    {
      var popup = $(this);
      var cont = popup.find('.popup_content');

      cont.css('max-height', (winH - 140) + 'px');
      popup.css('max-height', winH + 'px')
      popup.css(
      {
        'left': Math.round((winW - popup.width()) / 2) + 'px',
        'top': (Math.round((winH - popup.outerHeight()) / 2)) + 'px'
      });

      popup.css('visibility', 'visible');
    });
  },

  hidePopup: function (event, id)
  {
    if (typeof (event) == 'object' && PlugoBrowser.closePopupDisabled) return;

    $(id ? '#popupOverlay_' + id + ', #popup_' + id : '.popup, .popupOverlay').fadeOut(function ()
    {
      $(this).remove();
    });
  },

  showAlert: function (msg, closeAction)
  {
    this.showPopup(msg, 'alert', this.ed.getLang('plugobrowser_dlg.error', 'ERROR'), null, null, null, 420, closeAction);
  },

  setInsertMethod: function (insertMethod)
  {
    this.insertMethod = insertMethod;

    //Set active tab 
    $('#insert_params ul.tabs li a').removeClass('current');
    $('#insert_params ul.tabs li.insert_' + insertMethod + ' a').addClass('current');

    //Show / hide target property table
    $('#insert_params table[class^="insert_"]:not(.insert_' + insertMethod + ')').hide();
    $('#insert_params table.insert_' + insertMethod).show();

    $('#insert_params table[class^="insert_"]:visible tr[class^="insert_"]:not(.insert_' + insertMethod + ')').hide();
    $('#insert_params table[class^="insert_"]:visible tr.insert_' + insertMethod).show();

    if (insertMethod > 0) this.inputs.dimm_thumb.trigger('change');
    if (insertMethod == 2) this.inputs.dimm_full.trigger('change');
  },

  getRealPath: function (path)
  {
    var p = 0;
    path = (path + '').replace(new RegExp('~\~', 'g'), '/');
    if (path.indexOf('://') !== -1) p = 1;
    if (!p)
    {
      var docUrl = window.location.pathname;
      path = docUrl.substring(0, docUrl.lastIndexOf('/') + 1) + path;
    }

    exploded = path.split('/');
    path = [];
    for (var level in exploded)
    {
      if (exploded[level] == '.') continue;
      if (exploded[level] == '..')
      {
        if (path.length > 1) path.pop();
      }
      else
      {
        if ((path.length < 1) || (exploded[level] !== '')) path.push(exploded[level]);
      }
    }

    return path.join('/');
  },

  checkIsCustomDimm: function (el, relatedClass)
  {
    el = $(el);
    if (el.val() == 'custom') $('.' + relatedClass).show();
    else $('.' + relatedClass).hide();
  },

  setDisplayStyle: function (style)
  {
    this.displayStyle = style == 1 ? 1 : 0;

    $.cookie('plugoBrowser_displayStyle', this.displayStyle, {
      path: '/',
      expires: 1
    });

    $('#displayStyle').removeClass('ico_table_list ico_image_list').addClass('ico_' + (this.displayStyle ? 'table' : 'image') + '_list').attr('title', this.ed.getLang('plugobrowser_dlg.view_as_' + (this.displayStyle ? 'table' : 'thumbs'), 'Show only ' + (this.displayStyle ? 'files' : 'images')));

    this.readDir(this.selectedDir);
  },

  getPathNameFromEl: function (el)
  {
    el = $(el);
    if (!el.attr('data-path') && !el.attr('data-name')) el = el.parents('[data-path][data-name]');
    var path = el.attr('data-path');
    if (path && path != '/') path += '/';
    return [path, el.attr('data-name')];
  },

  toggleDisplayStyle: function ()
  {
    newDisplayStyle = !this.displayStyle;
    this.setDisplayStyle(newDisplayStyle);
  },

  //Global AJAX connector
  ajaxRequest: function (action, callback, data, sync)
  {
    if (!this.isTested && action != 'test') return;

    $.ajax(
    {
      url: 'ajax/' + action + '.php',
      data: data,
      dataType: 'json',
      async: !sync,
      success: callback,
      context: this,
      error: this.ajaxRequest_error
    });
  },


  //AJAX callbacks
  ajaxRequest_error: function (req, error)
  {
    if (req.status == 401) this.showAlert(this.ed.getLang('plugobrowser_dlg.not_logged', 'You have to be logged in to proceed'));
    else this.showAlert(this.ed.getLang('plugobrowser_dlg.ajax_error', 'There was a communication error'));
  },

  ajaxRequest_afterInitTest: function (data)
  {
    if (data.success)
    {
      this.isTested = true;

      for (var property in data.settings)
      {
        this.settings[property] = data.settings[property];
      }

      //Get defaults from cookies
      tmp = $.cookie('plugoBrowser_displayStyle');
      if (typeof (tmp) != 'undefined') this.displayStyle = (tmp == 1) ? 1 : 0;
      tmp = $.cookie('plugoBrowser_selectedDir');
      if (typeof (tmp) != 'undefined') this.selectedDir = tmp;
      tmp = $.cookie('plugoBrowser_ratioLock_thumb');
      if (typeof (tmp) != 'undefined') this.ratioLock_thumb = (tmp == 1) ? 1 : 0;
      tmp = $.cookie('plugoBrowser_ratioLock_full');
      if (typeof (tmp) != 'undefined') this.ratioLock_full = (tmp == 1) ? 1 : 0;

      $('#displayStyle').removeClass('ico_table_list ico_image_list').addClass('ico_' + (this.displayStyle ? 'table' : 'image') + '_list').attr('title', this.ed.getLang('plugobrowser_dlg.view_as_' + (this.displayStyle ? 'table' : 'thumbs'), 'Show only ' + (this.displayStyle ? 'files' : 'images')));

      this.bindHovers($('.filetree .menu_item'));

      //Init context menus
      $.contextMenu(
      {
        selector: '.contextMenu_image',
        build: function ($trigger, e)
        {
          $trigger.addClass('rightClicked');
          return {
            autoHide: true,
            hideCallback: function (key, options)
            {
              $trigger.removeClass('rightClicked');
            },
            items: {
              'insertFile': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.insert_as_file', 'Insert as File'),
                icon: 'insert_file',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.insert_as_file_accesskey', 'f'),
                callback: function (key, options)
                {
                  PlugoBrowser.selectFile(this, 0, true);
                }
              },
              'insertFull': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.insert_as_image', 'Insert Image'),
                icon: 'insert',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.insert_as_image_accesskey', 'i'),
                callback: function (key, options)
                {
                  PlugoBrowser.selectFile(this, 1, true);
                }
              },
              'insertThumb': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.insert_as_zoom_image', 'Insert Zoom Image'),
                icon: 'insert_zoom',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.insert_as_zoom_image_accesskey', 'z'),
                callback: function (key, options)
                {
                  PlugoBrowser.selectFile(this, 2, true);
                }
              },
              'view': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.view_image', 'View Image'),
                icon: 'view',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.view_image_accesskey', 'v'),
                callback: function (key, options)
                {
                  PlugoBrowser.showImgPreview(this);
                }
              },
              'rename': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.rename', 'Rename'),
                icon: 'rename',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.rename_accesskey', 'r'),
                callback: function (key, options)
                {
                  PlugoBrowser.showRename(this, true);
                }
              },
              'sep1': '---------',
              'delete': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.delete', 'Delete'),
                icon: 'delete',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.delete_accesskey', 'd'),
                callback: function (key, options)
                {
                  PlugoBrowser.initDeleteFile(this);
                }
              }
            }
          };
        }
      });

      $.contextMenu(
      {
        selector: '.contextMenu_file',
        build: function ($trigger, e)
        {
          $trigger.addClass('rightClicked');
          return {
            autoHide: true,
            hideCallback: function (key, options)
            {
              $trigger.removeClass('rightClicked');
            },
            items: {
              'insertFile': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.insert_as_file', 'Insert as File'),
                icon: 'insert_file',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.insert_as_file_accesskey', 'f'),
                callback: function (key, options)
                {
                  PlugoBrowser.selectFile(this, 0);
                }
              },
              'rename': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.rename', 'Rename'),
                icon: 'rename',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.rename_accesskey', 'r'),
                callback: function (key, options)
                {
                  PlugoBrowser.showRename(this, true);
                }
              },
              'sep1': '---------',
              'delete': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.delete', 'Delete'),
                icon: 'delete',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.delete_accesskey', 'd'),
                callback: function (key, options)
                {
                  PlugoBrowser.initDeleteFile(this);
                }
              }
            }
          };
        }
      });

      $.contextMenu(
      {
        selector: '.contextMenu_folder',
        build: function ($trigger, e)
        {
          $trigger.addClass('rightClicked');
          return {
            autoHide: true,
            hideCallback: function (key, options)
            {
              $trigger.removeClass('rightClicked');
              return true;
            },
            items: {
              'open': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.open_folder', 'Open folder'),
                icon: 'open',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.open_folder_accesskey', 'o'),
                callback: function (key, options)
                {
                  PlugoBrowser.initReadDir(this);
                }
              },
              'rename': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.rename', 'Rename'),
                icon: 'rename',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.rename_accesskey', 'r'),
                callback: function (key, options)
                {
                  PlugoBrowser.showRename(this);
                }
              },
              'sep1': '---------',
              'delete': {
                name: PlugoBrowser.ed.getLang('plugobrowser_dlg.delete', 'Delete'),
                icon: 'delete',
                accesskey: PlugoBrowser.ed.getLang('plugobrowser_dlg.delete_accesskey', 'd'),
                callback: function (key, options)
                {
                  PlugoBrowser.initDeleteDir(this);
                }
              }
            }
          };
        }
      });

      this.readDir();
    }
    else
    {
      this.isTested = false;

      var errText = '';
      for (var i = 0; i < data.errors.length; i++)
      {
        if (data.errors[i].length) errText += (errText.length ? '<br />' : '') + this.ed.getLang('plugobrowser_dlg.' + data.errors[i]) + '.';
      }

      if (errText) this.showAlert(errText, 'PlugoBrowser.redirectInitSet()');
      else PlugoBrowser.redirectInitSet();
    }
  },

  redirectInitSet: function ()
  {
    window.location.href = 'initSet.php';
  },

  ajaxRequest_afterReadDir: function (data)
  {
    this.selectedDir = data.path;
    $.cookie('plugoBrowser_selectedDir', this.selectedDir, {
      path: '/',
      expires: 1
    });

    $('#dirName').text(data.pathSplit.length == 1 ? this.ed.getLang('plugobrowser_dlg.root', 'Root') : data.dirName);

    $('#sidebar ul.filetree a.action_get_items').removeClass('active');
    el = $('#sidebar ul.filetree a.action_get_items[rel="' + data.path + '"]').map(function (i, tmpEl)
    {
      return ($(tmpEl).attr('rel') != data.path) ? null : tmpEl;
    });

    if (!el.length)
    {
      this.ajaxRequest('dirTree', function (data)
      {
        for (var curPath in data.dirList)
        {
          var el = $('#sidebar ul.filetree a.action_get_items[rel="' + curPath + '"]').map(function (i, tmpEl)
          {
            return ($(tmpEl).attr('rel') != curPath) ? null : tmpEl;
          }).parentsUntil('.clearfix');
          el.next('ul').remove();

          var tree = '<ul>';
          for (var i in data.dirList[curPath])
          {
            tree += '<li><div class="clearfix"><div class="menu_item"><a rel="' + this.escapeHtml((curPath != '/' ? curPath + '/' : '') + data.dirList[curPath][i]) + '" href="#" onclick="PlugoBrowser.readDir($(this).attr(\'rel\')); return false;" class="action_get_items">' + this.escapeHtml(data.dirList[curPath][i]) + '</a></div></div></li>';
          }

          tree += '</ul>';
          el.after(tree);

          this.bindHovers(el.next('ul'));
        }
      }, {
        path: data.path
      }, true);

      el = $('#sidebar ul.filetree a.action_get_items[rel="' + data.path + '"]').map(function (i, tmpEl)
      {
        return ($(tmpEl).attr('rel') != data.path) ? null : tmpEl;
      });
    }

    el.addClass('active');
    el = el.parentsUntil('.clearfix');
    el.next('ul').remove();

    var path = data.path != '/' ? data.path + '/' : '';

    var list = this.displayStyle ? '<ul id="list" class="items clearfix">' : '<table cellpadding="0" cellspacing="0" border="0" width="100%" class="filelist">' + '<tr>' + '<th colspan="2">' + this.ed.getLang('plugobrowser_dlg.filename', 'Filename') + '</th>' + '<th class="t-right" style="width: 60px;">' + this.ed.getLang('plugobrowser_dlg.size', 'Size') + '</th>' + '<th style="width: 90px;">' + this.ed.getLang('plugobrowser_dlg.last_modified', 'Last modified') + '</th>' + '<th style="width: 100px;">' + this.ed.getLang('plugobrowser_dlg.dimensions', 'Dimensions') + '</th>' + '<th class="w16">&nbsp;</th>' + '</tr>';

    var tree = '<ul>';
    for (var i in data.dirList)
    {
      var selectOnclick = 'onclick="PlugoBrowser.initReadDir(this); return false;"';
      tree += '<li><div class="clearfix"><div class="menu_item"><a rel="' + this.escapeHtml(path + data.dirList[i].name) + '" href="#" onclick="PlugoBrowser.readDir($(this).attr(\'rel\')); return false;" class="action_get_items">' + this.escapeHtml(data.dirList[i].name) + '</a></div></div></li>';

      list += this.displayStyle ? '<li data-path="' + this.escapeHtml(data.path == '/' ? '' : data.path) + '" data-name="' + this.escapeHtml(data.dirList[i].name) + '" class="file_container clearfix contextMenu_folder" class="img" ' + selectOnclick + '>' + '<div>' + '<a href="#"><img alt="" src="css/folder_default.gif"></a>' + '</div>' + '<div class="filename">' + this.escapeHtml(data.dirList[i].name) + '</div>' + '<a href="#" onclick="PlugoBrowser.initDeleteDir(this, event); return false;" class="action_button action_delete" title="' + this.ed.getLang('plugobrowser_dlg.delete_folder', 'Delete folder') + '"></a>' + '</li>' : '<tr class="contextMenu_folder" data-path="' + this.escapeHtml(data.path == '/' ? '' : data.path) + '" data-name="' + this.escapeHtml(data.dirList[i].name) + '" ' + selectOnclick + '>' + '<td class="w16 filetype"><img src="css/icons/folder.png" width="16" height="16" /></td>' + '<td class="filename"><a href="#">' + this.escapeHtml(data.dirList[i].name) + '</a></td>' + '<td class="filesize t-right">' + (data.dirList[i].size ? data.dirList[i].size : '') + '</td>' + '<td class="filemodified">' + data.dirList[i].last_modified + '</td>' + '<td class="filedimensions"></td>' + '<td class="w16 filetype delete"><a href="#" onclick="PlugoBrowser.initDeleteDir(this, event); return false;" title="' + this.ed.getLang('plugobrowser_dlg.delete_folder', 'Delete folder') + '"><img src="css/delete.png" alt="' + this.ed.getLang('plugobrowser_dlg.delete_folder', 'Delete folder') + '" width="16" height="16" /></a></td>' + '</tr>';
    }

    for (var i in data.fileList)
    {
      var isImg = data.fileList[i].width && data.fileList[i].height;
      var selectOnclick = 'onclick="PlugoBrowser.selectFile(this, ' + (isImg ? this.settings.default_image_action : 0) + ', ' + (isImg ? 'true' : 'false') + '); return false;"';

      list += this.displayStyle ? '<li class="file_container clearfix contextMenu_' + (isImg ? 'image' : 'file') + '" data-path="' + this.escapeHtml(data.path == '/' ? '' : data.path) + '" data-name="' + this.escapeHtml(data.fileList[i].name) + '" ' + selectOnclick + '>' + '<div class="img">' + '<a href="#"><img src="' + (isImg ? this.encodeURIComponentNoSlash(this.relativeUploadDir) + 'cache.php?src=/' + encodeURIComponent(path + data.fileList[i].name) + '&amp;w=104&amp;h=104' : 'css/icons/' + data.fileList[i].icon + '_big.png') + '" alt="" /></a>' + '</div>' + '<div class="filename">' + this.escapeHtml(data.fileList[i].name) + '</div>' + '<a href="#" onclick="PlugoBrowser.initDeleteFile(this, event); return false;" class="action_button action_delete" title="' + this.ed.getLang('plugobrowser_dlg.delete_file', 'Delete file') + '"></a>' + '</li>' : '<tr class="contextMenu_' + (isImg ? 'image' : 'file') + '" data-path="' + this.escapeHtml(data.path == '/' ? '' : data.path) + '" data-name="' + this.escapeHtml(data.fileList[i].name) + '" ' + selectOnclick + '>' + '<td class="w16 filetype"><img src="css/icons/' + data.fileList[i].icon + '.png" width="16" height="16" /></td>' + '<td class="filename"><a href="#">' + this.escapeHtml(data.fileList[i].name) + '</a></td>' + '<td class="filesize t-right">' + (data.fileList[i].size ? data.fileList[i].size : '') + '</td>' + '<td class="filemodified">' + data.fileList[i].last_modified + '</td>' + '<td class="filedimensions">' + (isImg ? data.fileList[i].width + '&times' + data.fileList[i].height : '') + '</td>' + '<td class="w16 filetype delete"><a href="#" onclick="PlugoBrowser.initDeleteFile(this, event); return false;" title="' + this.ed.getLang('plugobrowser_dlg.delete_file', 'Delete file') + '"><img src="css/delete.png" alt="' + this.ed.getLang('plugobrowser_dlg.delete_file', 'Delete file') + '" width="16" height="16" /></a></td>' + '</tr>';

    }

    tree += '</ul>';
    el.after(tree);

    list += this.displayStyle ? '</ul>' : '</table>';

    $('#directory_list').html(list);

    var breadCrumbs = '';
    var tmp = '';
    var breadLen = data.pathSplit.length;
    for (var i = 0; i < breadLen; i++)
    {
      if (i) tmp += (tmp ? '/' : '') + data.pathSplit[i];
      breadCrumbs += '<li' + (!i ? ' class="root"' : '') + '>' + (i < breadLen - 1 ? '<a href="#" onclick="PlugoBrowser.readDir(\'' + (i ? this.escapeForParam(tmp) : '/') + '\'); return false;">' : '') + (!i ? '<span>' : '') + this.escapeHtml(data.pathSplit[i]) + (!i ? '</span>' : '') + (i < breadLen - 1 ? '</a>' : '') + '</li>';
    }
    $('#breadCrumbs').html(breadCrumbs);

    //hover effect
    this.bindHovers(el.next('ul'));

    //some usefull class enhancement
    $('.filetree ul li:first-child').addClass('li_first');
    $('.filetree ul li:last-child').addClass('li_last');
  },

  ajaxRequest_afterDeleteFile: function (data)
  {
    if (data.result) this.readDir(data.path);
    else this.showAlert(this.ed.getLang('plugobrowser_dlg.cannot_delete_file', 'Cannot delete file'));
  },

  ajaxRequest_afterDeleteDir: function (data)
  {
    if (data.result) this.readDir(data.path);
    else this.showAlert(this.ed.getLang('plugobrowser_dlg.cannot_delete_dir', 'Cannot delete folder'));
  },

  ajaxRequest_afterSelectFile: function (data, insertMethod)
  {
    if (data.fileInfo)
    {
      this.showInsertForm(
        this.imgSelected ? this.encodeURIComponentNoSlash(this.relativeUploadDir) + 'cache.php?src=/' + encodeURIComponent(data.fileInfo.relativePath) + '&w=200&h=265' : 'css/icons/' + data.fileInfo.icon + '_big.png',
				'<span>' + this.ed.getLang('plugobrowser_dlg.file', 'File') + ':</span> ' + data.fileInfo.baseName + '<span> | ' + this.ed.getLang('plugobrowser_dlg.last_modified', 'Last modified') + ':</span> ' + data.fileInfo.modified + '<br /><span>' + this.ed.getLang('plugobrowser_dlg.size', 'Size') + ':</span> ' + data.fileInfo.size + (data.fileInfo.width ? '<span> | ' + this.ed.getLang('plugobrowser_dlg.dimensions', 'Dimensions') + ':</span> ' + data.fileInfo.width + ' x ' + data.fileInfo.height : '')
			);

      this.setInsertMethod(insertMethod);

      this.inputs.alt.val(data.fileInfo.fileName);
      this.inputs.anchorTitle.val(data.fileInfo.fileName);
      if (data.fileInfo.width)
      {
			  this.inputs.width_full.val(data.fileInfo.width);
			  this.inputs.width_thumb.val(data.fileInfo.width);			  
      }        

      this.selectedFile = data.fileInfo;
      this.selectedRatio = data.fileInfo.width ? data.fileInfo.width / data.fileInfo.height : null;
      if (this.imgSelected)
      {
        this.calculateRatio(this.inputs.width_thumb[0]);
        this.calculateRatio(this.inputs.width_full[0]);
      }
    }
    else
    {
      this.readDir(data.path);
      alert(this.ed.getLang('plugobrowser_dlg.file_doesnt_exists', 'Selected file does not exist'));
    }
  },

  ajaxRequest_afterSaveSettings: function (data)
  {
    if (data.result)
    {
      this.hidePopup();
      this.initTest();
    }
    else this.showAlert(this.ed.getLang('plugobrowser_dlg.cant_save_settings', 'Can’t save settings. Please try again.'));
  },

  //Filesystem functions
  updateDirTreeOptions: function (callback)
  {
    $.ajax(
    {
      url: 'ajax/getDirTreeOptions.php',
      async: false,
      dataType: 'json',
      context: this,
      success: function (data)
      {
        callback.call(this, data);
      }
    });
  },

  selectFile: function (el, insertMethod, isImg)
  {
    this.imgSelected = (isImg == true);
    var pathName = this.getPathNameFromEl(el);

    this.getFileInfo(pathName.join(''), function (data)
    {
      PlugoBrowser.ajaxRequest_afterSelectFile(data, insertMethod);
    });
  },

  initDeleteFile: function (el, event)
  {
    if (event) event.stopPropagation();
    this.deleteFile(this.getPathNameFromEl(el).join(''));
  },

  initDeleteDir: function (el, event)
  {
    if (event) event.stopPropagation();
    this.deleteDir(this.getPathNameFromEl(el).join(''));
  },

  initTest: function ()
  {
    this.ajaxRequest('test', this.ajaxRequest_afterInitTest);
  },

  initReadDir: function (el)
  {
    this.readDir(this.getPathNameFromEl(el).join(''));
  },

  readDir: function (path)
  {
    if (!path) path = this.selectedDir;
    this.ajaxRequest('dirList', this.ajaxRequest_afterReadDir, {
      path: path
    });
  },

  getFileInfo: function (path, callback)
  {
    this.ajaxRequest('getFileInfo', callback, {
      path: path
    }, true);
  },

  deleteFile: function (path)
  {
    if (confirm(this.ed.getLang('plugobrowser_dlg.confirm_delete_file', 'Do you really want to delete file') + '?'))
    {
      this.ajaxRequest('deleteFile', this.ajaxRequest_afterDeleteFile, {
        path: path
      });
    }
  },

  deleteDir: function (path)
  {
    if (confirm(this.ed.getLang('plugobrowser_dlg.confirm_delete_dir', 'Do you really want to delete folder') + '?'))
    {
      this.ajaxRequest('deleteDir', this.ajaxRequest_afterDeleteDir, {
        path: path
      });
    }
  },

  createDir: function ()
  {
    var dirName = $.trim($('#newDir_name').val());
    if (dirName.length)
    {
      var canInsert = true;
      var reservedChars = ['<', '>', ':', '"', '/', '\\', '|', '?', '*'];
      for (var i in reservedChars)
      {
        if (dirName.indexOf(reservedChars[i]) != -1)
        {
          canInsert = false;
          this.showAlert(this.ed.getLang('plugobrowser_dlg.dir_name_reserved_chars', 'Folder name contains reserved characters'));
          break;
        }
      }

      if (canInsert)
      {
        this.ajaxRequest('createDir', this.afterCreateDir, {
          name: dirName,
          parent: $('#newDir_parent').val()
        });
      }
    }
    else this.showAlert(this.ed.getLang('plugobrowser_dlg.fill_dir_name', 'Please fill in folder name'));
  },

  afterCreateDir: function (data)
  {
    if (!data.result) this.showAlert(this.ed.getLang('plugobrowser_dlg.cant_create_dir', 'Can’t create folder'));
    else
    {
      this.readDir(data.path);
      this.hidePopup();
    }
  },

  showRename: function (el, isFile)
  {
    var pathName = this.getPathNameFromEl(el);
    var name = pathName[1];
    var ext = '';

    if (isFile)
    {
      var pos = name.lastIndexOf('.')
      if (pos != -1)
      {
        ext = name.substring(pos, name.length);
        name = name.substring(0, pos);
      }
    }

    this.showPopup('<table border="0" cellspacing="0" cellpadding="0"><tr><td class="t-right">' + this.ed.getLang('plugobrowser_dlg.old_name', 'Old name') + ':</td><td><input type="hidden" id="rename_prevName" name="rename[prevName]" value="' + this.escapeHtml(pathName[1]) + '" />' + this.escapeHtml(pathName[1]) + '</td></tr><tr><td class="t-right">' + this.ed.getLang('plugobrowser_dlg.new_name', 'New name') + ':</td><td><input type="hidden" id="rename_ext" name="rename[ext]" value="' + this.escapeHtml(ext) + '" /><input type="text" id="rename_newName" name="rename[newName]" onkeyup="PlugoBrowser.handleEsc(event);" onkeypress="PlugoBrowser.nameKey(event);" value="' + this.escapeHtml(name) + '" />' + ext + '</td></tr></table>', null, this.ed.getLang('plugobrowser_dlg.rename', 'Rename'), this.ed.getLang('plugobrowser_dlg.rename', 'Rename'), 'PlugoBrowser.rename(\'' + this.escapeForParam(pathName[0]) + '\')');

    window.setTimeout(function ()
    {
      $('#rename_newName').focus();
    }, 100);
  },

  rename: function (path)
  {
    var newName = $.trim($('#rename_newName').val());
    if (!newName.length) this.showAlert(this.ed.getLang('plugobrowser_dlg.fill_filename', 'Please fill in file name'));
    else
    {
      var prevName = $('#rename_prevName').val();

      var ext = $('#rename_ext').val();
      if (ext != undefined) newName += ext;

      if (prevName != newName) this.ajaxRequest('rename', this.afterRename, {
        path: path ? path : '/',
        prevName: prevName,
        newName: newName
      }, true);
      else this.hidePopup();
    }
  },

  afterRename: function (data)
  {
    if (data.result == 'true')
    {
      this.hidePopup();
      this.readDir(data.path);
    }
    else this.showAlert(this.ed.getLang('plugobrowser_dlg.rename_' + data.result))
  },

  //Dialogs opening
  showImgPreview: function (el)
  {
    var pathName = this.getPathNameFromEl(el);
    this.getFileInfo(pathName.join(''), function (data)
    {
      if (data.fileInfo) PlugoBrowser.showPopup('<div class="loading"><img alt="" src="' + PlugoBrowser.encodeURIComponentNoSlash(PlugoBrowser.relativeUploadDir) + 'cache.php?src=/' + encodeURIComponent(data.fileInfo.relativePath) + '&w=380&h=380" style="visibility: hidden;" onload="PlugoBrowser.positionPopup(); $(this).css(\'visibility\', \'visible\');" /></div>', null, pathName[1], null, null, '<span>' + PlugoBrowser.ed.getLang('plugobrowser_dlg.file', 'File') + ':</span> ' + data.fileInfo.baseName + '<span> | ' + PlugoBrowser.ed.getLang('plugobrowser_dlg.last_modified', 'Last modified') + ':</span> ' + data.fileInfo.modified + '<br /><span>' + PlugoBrowser.ed.getLang('plugobrowser_dlg.size', 'Size') + ':</span> ' + data.fileInfo.size + (data.fileInfo.width ? '<span> | ' + PlugoBrowser.ed.getLang('plugobrowser_dlg.dimensions', 'Dimensions') + ':</span> ' + data.fileInfo.width + ' x ' + data.fileInfo.height : ''));
    });
  },

  showNewDir: function ()
  {
    this.updateDirTreeOptions(this.afterShowNewDir);
  },

  afterShowNewDir: function (data)
  {
    var popupId = this.showPopup('<table border="0" cellspacing="0" cellpadding="0"><tr><td class="t-right">' + this.ed.getLang('plugobrowser_dlg.new_dir_name', 'Folder name') + ':</td><td><input type="text" id="newDir_name" name="newDir[name]" onkeyup="PlugoBrowser.handleEsc(event);" onkeypress="PlugoBrowser.nameKey(event);" /></td></tr><tr><td class="t-right">' + this.ed.getLang('plugobrowser_dlg.new_dir_parent', 'Parent folder') + ':</td><td><select id="newDir_parent" name="newDir[parent]" class="dirTree">' + data.dirTree + '</select></td></tr></table>', null, this.ed.getLang('plugobrowser_dlg.new_folder', 'New Folder'), this.ed.getLang('plugobrowser_dlg.create', 'Create'), 'PlugoBrowser.createDir()');

    var dirSelect = $('#popup_' + popupId + ' #newDir_parent');
    dirSelect.find('option:first').html(this.ed.getLang('plugobrowser_dlg.root', 'Root'));
    dirSelect.find('option[value="' + this.selectedDir + '"]').attr('selected', 'selected');

    window.setTimeout(function ()
    {
      $('#newDir_name').focus();
    }, 100);
  },

  nameKey: function (event)
  {
    var reservedChars = ['<', '>', ':', '"', '/', '\\', '|', '?', '*'];
    var keyCode = event.keyCode ? event.keyCode : event.which;
    if ($.inArray(String.fromCharCode(keyCode), reservedChars) != -1) event.preventDefault();
    else if (keyCode == 13) $('#popup_actionBtn').trigger('mouseup');
  },

  numInputKeyDown: function (el)
  {
    el = $(el);
    el.data('oldValue', el.val());
  },

  numInputKeyUp: function (el)
  {
    el = $(el);
    var val = el.val();
    if (val != '' && (isNaN(val) || val < 1)) el.val(el.data('oldValue'));
  },

  handleEsc: function (event)
  {
    var keyCode = event.keyCode ? event.keyCode : event.which;
    if (keyCode == 27)
    {
      event.stopPropagation();
      event.preventDefault();
      this.hidePopup();
    }
  },

  showUpload: function ()
  {
    this.updateDirTreeOptions(this.afterShowUpload);
  },

  afterShowUpload: function (data)
  {
    var popupId = this.showPopup('<table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td><p>' + this.ed.getLang('plugobrowser_dlg.upload_parent', 'Choose destination folder for upload') + ':</p><select id="upload_path" name="upload[path]" class="dirTree">' + data.dirTree + '</select></td></tr><tr><td id="upload_container"><div id="upload_links" class="clearfix"><a id="upload_pickFiles" href="#">' + this.ed.getLang('plugobrowser_dlg.add_file', 'Add file') + '</a><a id="upload_removeFiles" href="#">' + this.ed.getLang('plugobrowser_dlg.remove_all', 'Remove all files') + '</a></div><div id="upload_fileList"></div></td></tr></table>', null, this.ed.getLang('plugobrowser_dlg.upload', 'Upload'), this.ed.getLang('plugobrowser_dlg.upload', 'Upload'), 'PlugoBrowser.upload()', null, 700);

    this.initUploader();

    var dirSelect = $('#popup_' + popupId + ' #upload_path');
    dirSelect.find('option:first').html(this.ed.getLang('plugobrowser_dlg.root', 'Root'));
    dirSelect.find('option[value="' + this.selectedDir + '"]').attr('selected', 'selected');

    $('#popup_' + popupId + ' #upload_removeFiles').click(function ()
    {
      PlugoBrowser.uploader.splice();
      $('#upload_fileList>div').remove();
      return false;
    });
  },

  showSettings: function ()
  {
    var dia = this.settings.default_image_action;

    var dimmHtml = '';
    if (this.settings.dimensions.length)
    {
      var dimm = this.settings.dimensions.split('~~');
      for (var i in dimm)
      {
        splitted = dimm[i].split('|');
        splitted[1] = $.trim(splitted[1]);
        dimmHtml += '<option value="' + dimm[i] + '">' + (splitted[1] ? splitted[1] + ' (' : '') + splitted[0] + (splitted[1] ? ')' : '') + '</option>';
      }
    }

    var tzHtml = '';
    var timeZones = this.getTimezoneList();
    var selTz = this.settings.timezone.split('|');
    for (var offset in timeZones)
    {
      var abs = Math.abs(offset);
      var hours = parseInt(abs);
      var minutes = abs - hours;
      var prefix = '(UTC' + (offset ? ' ' + (offset > 0 ? '+' : '-') + hours + ':' + (minutes ? 60 * minutes : '00') : NULL) + ') ';

      if (typeof (timeZones[offset]) == 'object')
      {
        for (var city in timeZones[offset])
        {
          tzHtml += '<option value="' + timeZones[offset][city] + '"' + (selTz[0] == timeZones[offset][city] ? ' selected="selected"' : '') + '>' + prefix + timeZones[offset][city] + '</option>';
        }
      }
      else tzHtml += '<option value="' + timeZones[offset] + '"' + (selTz[0] == timeZones[offset] ? ' selected="selected"' : '') + '>' + prefix + timeZones[offset] + '</option>';
    }

    var popupId = this.showPopup('<div class="settings_wrap clearfix">' + '<div class="settings_left">' + '<table border="0" cellspacing="0" cellpadding="0" class="table_settings">' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.upload_dir', 'Upload dir') + ':</p><input type="text" id="settings_upload_dir" name="settings[upload_dir]" value="' + this.escapeHtml(this.settings.upload_dir) + '" onkeypress="PlugoBrowser.settings_uploadDirKey(event);" /></td>' + '</tr>' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.img_rel', 'Image link rel') + ':</p>' + '<input type="text" id="settings_img_rel" name="settings[img_rel]" value="' + this.escapeHtml(this.settings.img_rel) + '" onkeypress="PlugoBrowser.settings_imgRelKey(event);" /></td>' + '</tr>' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.default_image_action', 'Default image action') + ':</p>' + '<select id="settings_default_image_action" name="settings[default_image_action]">' + '<option value="0"' + (dia == 0 ? ' selected="selected"' : '') + '>' + this.ed.getLang('plugobrowser_dlg.default_image_action_file', 'Insert as File') + '</option>' + '<option value="1"' + (dia == 1 ? ' selected="selected"' : '') + '>' + this.ed.getLang('plugobrowser_dlg.default_image_action_thumb', 'Insert Image') + '</option>' + '<option value="2"' + (dia == 2 ? ' selected="selected"' : '') + '>' + this.ed.getLang('plugobrowser_dlg.default_image_action_thumb_zoom', 'Insert Zoom Image') + '</option>' + '</select>' + '</td>' + '</tr>' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.img_wrap_before', 'HTML before image') + ':</p><input type="text" id="settings_img_wrap_before" name="settings[img_wrap_before]" value="' + this.escapeHtml(this.settings.img_wrap_before) + '" /></td>' + '</tr>' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.img_wrap_after', 'HTML after image') + ':</p><input type="text" id="settings_img_wrap_after" name="settings[img_wrap_after]" value="' + this.escapeHtml(this.settings.img_wrap_after) + '" /></td>' + '</tr>' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.link_props_pattern', 'Link properties format') + ':</p>' + '<input type="text" id="settings_link_props_pattern" name="settings[link_props_pattern]" value="' + this.escapeHtml(this.settings.link_props_pattern) + '" />' + '</td>' + '</tr>' + '</table>' + '</div>'

    + '<div class="settings_right">' + '<table border="0" cellspacing="0" cellpadding="0" class="table_settings">' + '<tr>' + '<td>' + '<p>' + this.ed.getLang('plugobrowser_dlg.new_dimension', 'New dimension') + ':</p>' + '<div class="inner">' + '<table border="0" cellspacing="0" cellpadding="0">' + '<tr>' + '<td class="t-right">' + this.ed.getLang('plugobrowser_dlg.w', 'W') + ':' + '</td>' + '<td colspan="2">' + '<input type="text" id="settings_dimension_w" class="short_input" /> px &nbsp;&nbsp;&nbsp; ' + this.ed.getLang('plugobrowser_dlg.h', 'H') + ':&nbsp; ' + '<input type="text" id="settings_dimension_h" class="short_input" /> px' + '</td>' + '</tr>' + '<tr>' + '<td>' + this.ed.getLang('plugobrowser_dlg.dimension_alias', 'Alias') + ':' + '</td>' + '<td>' + '<input type="text" id="settings_dimension_title" />' + '</td>' + '<td>' + '<a href="#" onclick="PlugoBrowser.settings_addDimension(); return false;" class="btn btn-success">' + this.ed.getLang('plugobrowser_dlg.add', 'Add') + '</a>' + '</td>' + '</tr>' + '</table>' + '</div>' + '</td>' + '</tr>' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.dimensions', 'Dimensions') + ':</p>' + '<select name="settings[dimensions]" id="settings_dimensions" multiple="multiple">' + dimmHtml + '</select>' + '<p class="arrow_top"><a href="#" onclick="PlugoBrowser.settings_removeDimension(); return false;" class="link_danger">' + this.ed.getLang('plugobrowser_dlg.remove', 'Remove') + '</a></p>' + '</td>' + '</tr>' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.timezone', 'Time zone') + ':</p>' + '<select id="settings_timezone" name="settings[timezone]">' + tzHtml + '</select>' + '</td>' + '<tr>' + '<tr>' + '<td><p>' + this.ed.getLang('plugobrowser_dlg.forbidden_extensions', 'Forbidden extensions') + ':</p><input type="text" id="settings_forbidden_extensions" name="settings[forbidden_extensions]" value="' + this.escapeHtml(this.settings.forbidden_extensions) + '" onkeypress="PlugoBrowser.settings_forbiddenExtKey(event);" />' + '<p class="note"><strong>' + this.ed.getLang('plugobrowser_dlg.forbidden_extensions_permanent', 'Permanently forbidden extensions') + '</strong>:<br />' + this.settings.forbidden_extensions_permanent.split(',').join(', ') + '</p>' + '</td>' + '</tr>' + '</table>' + '</div>' + '</div>', null, this.ed.getLang('plugobrowser_dlg.settings', 'Settings'), this.ed.getLang('plugobrowser_dlg.save', 'Save'), 'PlugoBrowser.saveSettings()', null, 850);
  },

  settings_addDimension: function ()
  {
    var input_w = $('#settings_dimension_w');
    var input_h = $('#settings_dimension_h');
    var input_title = $('#settings_dimension_title');

    var w = input_w.val();
    var h = input_h.val();

    if (!this.isInt(w) || w < 1 || !this.isInt(h) || h < 1)
    {
      this.showAlert(this.ed.getLang('plugobrowser_dlg.new_dimension_error', 'Dimensions must be integers'));
      return false;
    }

    var title = this.escapeHtml($.trim(input_title.val()));
    $('#settings_dimensions').append('<option value="' + w + 'x' + h + '|' + title + '">' + (title ? title + ' (' : '') + w + '&times;' + h + (title ? ')' : '') + '</option>');

    input_w.val('');
    input_h.val('');
    input_title.val('');

    this.saveDimensions();
  },

  settings_removeDimension: function ()
  {
    $('#settings_dimensions option:selected').remove();
    this.saveDimensions();
  },

  saveDimensions: function ()
  {
    var dimensions = $('#settings_dimensions option').map(function ()
    {
      return this.value;
    }).get().join('~~');
    
    this.ajaxRequest('saveSettings', null, {
      settings: {
        dimensions: dimensions
      }
    });

    this.settings['dimensions'] = dimensions;
  },

  settings_forbiddenExtKey: function (event)
  {
    var reservedChars = ['<', '>', ':', '"', '/', '\\', '|', '?', '*', '.'];
    var keyCode = event.keyCode ? event.keyCode : event.which;
    if ($.inArray(String.fromCharCode(keyCode), reservedChars) != -1) event.preventDefault();
  },

  settings_uploadDirKey: function (event)
  {
    var reservedChars = ['<', '>', ':', '"', '|', '?', '*'];
    var keyCode = event.keyCode ? event.keyCode : event.which;
    if ($.inArray(String.fromCharCode(keyCode), reservedChars) != -1) event.preventDefault();
  },

  settings_imgRelKey: function (event)
  {
    var reservedChars = ['<', '>', '"', '\\'];
    var keyCode = event.keyCode ? event.keyCode : event.which;
    if ($.inArray(String.fromCharCode(keyCode), reservedChars) != -1) event.preventDefault();
  },

  saveSettings: function ()
  {
    this.ajaxRequest('saveSettings', this.ajaxRequest_afterSaveSettings, {
      settings: {
        upload_dir: $('#settings_upload_dir').val(),
        img_wrap_before: $('#settings_img_wrap_before').val(),
        img_wrap_after: $('#settings_img_wrap_after').val(),
        forbidden_extensions: $('#settings_forbidden_extensions').val().replace(new RegExp(' ', 'g'), ''),
        default_image_action: $('#settings_default_image_action option:selected').val(),
        dimensions: $('#settings_dimensions option').map(function ()
        {
          return this.value;
        }).get().join('~~'),
        link_props_pattern: $('#settings_link_props_pattern').val(),
        img_rel: $('#settings_img_rel').val(),
        timezone: $('#settings_timezone option:selected').val()
      }
    });
  },

  showInsertForm: function (prevUrl, fileInfo)
  {
    this.showPopup(
		  '<div id="insert_preview"><img src="' + prevUrl + '" alt="" /></div>'
			+ '<div id="insert_params">'
			  + '<div id="tabs">'
				  + '<ul class="tabs">'
					  + (
						  this.imgSelected ? '<li class="insert_1"><a href="#" onclick="PlugoBrowser.setInsertMethod(1); return false;">' + this.ed.getLang('plugobrowser_dlg.insert_as_image_tab', 'Insert<br />IMAGE') + '</a></li>'
						  + '<li class="insert_2"><a href="#" onclick="PlugoBrowser.setInsertMethod(2); return false;">' + this.ed.getLang('plugobrowser_dlg.insert_as_zoom_image_tab', 'Insert<br />ZOOM IMAGE') + '</a></li>' : ''
						)
						+ '<li class="insert_0"><a href="#" onclick="PlugoBrowser.setInsertMethod(0); return false;">' + this.ed.getLang('plugobrowser_dlg.insert_as_file_tab', 'Insert<br />AS FILE') + '</a></li>'
					+ '</ul>'
					+ '<div class="tabs_content img_template">'
					  + '<table border="0" cellspacing="0" cellpadding="0" class="insert_0">'
						  + '<tbody>'
							  + '<tr>'
								  + '<td class="t-right">' + this.ed.getLang('plugobrowser_dlg.anchor_text', 'Anchor Text') + ':</td>'
									+ '<td><input type="text" id="insert_anchor_title" name="insert[anchor_title]" /></td>'
								+ '</tr>'
								+ '<tr>'
								  + '<td class="t-right">' + this.ed.getLang('plugobrowser_dlg.title', 'Link Title') + ':</td>'
									+ '<td><input type="text" id="insert_file_title" name="insert[file_title]" /></td>'
									+ '<td></td>'
								+ '</tr>'
								+ '<tr>'
								  + '<td>&nbsp;</td>'
									+ '<td colspan="3">'
									  + '<input type="checkbox" class="checkBox" id="insert_filesize" name="insert[filesize]" value="1" /> <label for="insert_filesize">' + this.ed.getLang('plugobrowser_dlg.insert_filesize', 'Insert filesize') + '</label> &nbsp;&nbsp; <input type="checkbox" class="checkBox" id="insert_ext" name="insert[insert_ext]" value="1" /> <label for="insert_ext">' + this.ed.getLang('plugobrowser_dlg.insert_extension', 'Insert extension') + '</label>'
									+ '</td>'
								+ '</tr>'
							+ '</tbody>'
						+ '</table>'
						+ '<table border="0" cellspacing="0" cellpadding="0" class="insert_1 insert_2">'
						  + '<tbody>'
							  + '<tr class="insert_2">'
								  + '<td>' + this.ed.getLang('plugobrowser_dlg.title', 'Link Title') + ':</td>'
									+ '<td colspan="3">'
									  + '<input type="text" name="insert[title]" id="insert_title" class="f-left" />'
									+ '</td>'
								+ '</tr>'
								+ '<tr>'
								  + '<td>' + this.ed.getLang('plugobrowser_dlg.alt', 'Image Alt') + ':</td>'
									+ '<td colspan="3">'
									  + '<input type="text" name="insert[alt]" id="insert_alt" class="f-left" />'
									+ '</td>'
								+ '</tr>'
                + '<tr class="insert_2" style="display:none;">'
                  + '<td>Thumnail Size:</td>'
                  + '<td colspan="3">'
                    + 'Width: <input type="text" name="insert[manualwidth]" id="insert_manualwidth" class="short_input" /> &times; Height: <input type="text" name="insert[manualheight]" id="insert_manualheight" class="short_input" />'
                  + '</td>'
                + '</tr>'
								+ '<!--<tr class="insert_1 insert_2 style="display:none">'
								  + '<td>' + this.ed.getLang('plugobrowser_dlg.thumb_size', 'Thumb size') + ':</td>'
									+ '<td>'
									  + '<select onchange="PlugoBrowser.checkIsCustomDimm(this, \'insert_thumb_custom\');" name="insert[dimensions_thumb]" id="insert_dimensions_thumb">'
										  + '<option value="original">' + this.ed.getLang('plugobrowser_dlg.original_size', 'Original size') + '</option>'
											+ '<option value="custom">' + this.ed.getLang('plugobrowser_dlg.custom', 'Custom') + '</option>'
										+ '</select>'
									+ '</td>'
									+ '<td><label for="insert_crop_thumb">' + this.ed.getLang('plugobrowser_dlg.crop', 'Crop') + '</label>:</td>'
									+ '<td><input type="checkbox" value="1" name="insert[crop_thumb]" id="insert_crop_thumb" class="checkBox" /></td>'
								+ '</tr>'
								+ '<tr class="insert_thumb_custom insert_1 insert_2" style="display: none;">'
								  + '<td>&nbsp;</td>'
									+ '<td colspan="3">'
									  + '<table border="0" cellspacing="0" cellpadding="0">'
										  + '<tr>'
											  + '<td>'
												  + '<div class="td_arrow"><img src="css/arrow.gif" alt="" width="18" height="11" /></div>' + this.ed.getLang('plugobrowser_dlg.w', 'W') + ':&nbsp; <input type="text" name="insert[thumb_width]" id="insert_thumb_width" class="short_input" onchange="PlugoBrowser.calculateRatio(this);" onkeydown="PlugoBrowser.numInputKeyDown(this);" onkeyup="PlugoBrowser.numInputKeyUp(this);" />&nbsp;px'
												+ '</td>'
												+ '<td><a id="ratioLock_thumb" class="ratioLock' + (this.ratioLock_thumb == 1 ? ' active' : '') + '" href="#" onclick="PlugoBrowser.toggleRatioLock_thumb(); return false;" title="' + this.ed.getLang('plugobrowser_dlg.lock_aspect_ratio', 'Lock aspect ratio') + '">&nbsp;</a></td>'
												+ '<td>'
												  + this.ed.getLang('plugobrowser_dlg.h', 'H') + ':&nbsp; <input type="text" name="insert[thumb_height]" id="insert_thumb_height" class="short_input" onchange="PlugoBrowser.calculateRatio(this);" onkeydown="PlugoBrowser.numInputKeyDown(this);" onkeyup="PlugoBrowser.numInputKeyUp(this);" />&nbsp;px'
											  + '</td>'
											+ '</tr>'
										+ '</table>'
									+ '</td>'
								+ '</tr>'
								+ '<tr class="insert_2">'
								  + '<td>' + this.ed.getLang('plugobrowser_dlg.full_size', 'Full size') + ':</td>'
									+ '<td>'
									  + '<select onchange="PlugoBrowser.checkIsCustomDimm(this, \'insert_full_custom\');" name="insert[dimensions_full]" id="insert_dimensions_full">'
										  + '<option value="original">' + this.ed.getLang('plugobrowser_dlg.original_size', 'Original size') + '</option>'
											+ '<option value="custom">' + this.ed.getLang('plugobrowser_dlg.custom', 'Custom') + '</option>'
										+ '</select>'
									+ '</td>'
									+ '<td><label for="insert_crop_full">' + this.ed.getLang('plugobrowser_dlg.crop', 'Crop') + '</label>:</td>'
									+ '<td>'
									  + '<input type="checkbox" value="1" name="insert[crop_full]" id="insert_crop_full" class="checkBox" />'
									+ '</td>'
								+ '</tr>'
								+ '<tr class="insert_full_custom insert_2" style="display: none;">'
								  + '<td>&nbsp;</td>'
									+ '<td colspan="3">'
									  + '<table border="0" cellspacing="0" cellpadding="0">'
										  + '<tr>'
											  + '<td>'
												  + '<div class="td_arrow"><img src="css/arrow.gif" alt="" width="18" height="11" /></div>' + this.ed.getLang('plugobrowser_dlg.w', 'W') + ':&nbsp; <input type="text" name="insert[full_width]" id="insert_full_width" class="short_input" onchange="PlugoBrowser.calculateRatio(this);" onkeydown="PlugoBrowser.numInputKeyDown(this);" onkeyup="PlugoBrowser.numInputKeyUp(this);" />&nbsp;px'
												+ '</td>'
												+ '<td><a id="ratioLock_full" class="ratioLock' + (this.ratioLock_full == 1 ? ' active' : '') + '" href="#" onclick="PlugoBrowser.toggleRatioLock_full(); return false;" title="' + this.ed.getLang('plugobrowser_dlg.lock_aspect_ratio', 'Lock aspect ratio') + '">&nbsp;</a></td>'
												+ '<td>' + this.ed.getLang('plugobrowser_dlg.h', 'H') + ':&nbsp <input type="text" name="insert[full_height]" id="insert_full_height" class="short_input" onchange="PlugoBrowser.calculateRatio(this);" onkeydown="PlugoBrowser.numInputKeyDown(this);" onkeyup="PlugoBrowser.numInputKeyUp(this);" />&nbsp;px'
											+ '</td>'
										+ '</tr>'
			  						+ '</table>'
		  						+ '</td>'
	  						+ '</tr>-->'
  							+ '<tr>'
							    + '<td>' + this.ed.getLang('plugobrowser_dlg.image_class', 'Image class') + ':</td>'
							  	+ '<td colspan="3">'
						  		  + '<select id="insert_image_class" name="insert[image_class]" class="f-left"></select>'
					  			+ '</td>'
				  			+ '</tr>'
			  			+ '</tbody>'
					  + '</table>'
				  + '</div>'
			  + '</div>'
		  + '</div>',
		  null,
		  this.ed.getLang('plugobrowser_dlg.choose_insert_method', 'Choose insert method'),
		  this.ed.getLang('plugobrowser_dlg.insert', 'Insert'),
		  'PlugoBrowser.doInsert()',
		  fileInfo,
		  720
		);

    //Init inputs
    this.inputs = {
      alt: $('#insert_alt'),
      title: $('#insert_title'),
      dimm_thumb: $('#insert_dimensions_thumb'),
      dimm_full: $('#insert_dimensions_full'),
      width_thumb: $('#insert_thumb_width'),
      height_thumb: $('#insert_thumb_height'),
      width_full: $('#insert_full_width'),
      height_full: $('#insert_full_height'),
      crop_thumb: $('#insert_crop_thumb'),
      crop_full: $('#insert_crop_full'),
      imageClass: $('#insert_image_class'),

      anchorTitle: $('#insert_anchor_title'),
      fileTitle: $('#insert_file_title'),
      insertFilesize: $('#insert_filesize'),
      insertExt: $('#insert_ext'),
      manualwidth: $('#insert_manualwidth'),
      manualheight: $('#insert_manualheight')
    };

    this.initClassList();
    this.initDimmSelects();

    for (var i in this.inputs)
    {
      var el = this.inputs[i];
      var id = el.attr('id');
      if (id == 'insert_title') continue;

      var lastVal = $.cookie('plugoBrowser_' + id);
      if (typeof (lastVal) != 'undefined')
      {
        var type = el.attr('type');
        if (type == 'text' && lastVal.length) el.val(lastVal);
        else if (type == 'checkbox')
        {
          if (lastVal == true) el.attr('checked', 'checked');
        }
        else if (el[0].tagName.toLowerCase() == 'select') el.find('option[value="' + lastVal + '"]').attr('selected', 'selected');
      }

      el.change(function ()
      {
        var el = $(this);
        var id = el.attr('id');
        if (id == 'insert_title') return;

        var value = (el.attr('type') == 'checkbox') ? (el.attr('checked') ? 1 : 0) : el.val();

        $.cookie('plugoBrowser_' + id, value, {
          path: '/',
          expires: 1
        });
      });
    };

    this.inputs.dimm_thumb.trigger('change');
    this.inputs.dimm_full.trigger('change');
  },

  initClassList: function ()
  {
    var classList = [];

    if (advStyles = tinyMCEPopup.getParam('theme_advanced_styles'))
    {
      advStyles = advStyles.split(';');
      for (var i = 0; i < advStyles.length; i++)
      {
        style = advStyles[i].split('=');
        classList.push(
        {
          'title': style[0],
          'class': style[1]
        });
      }
    }
    else classList = tinyMCEPopup.editor.dom.getClasses();

    if (classList.length > 0)
    {
      this.inputs.imageClass.find('option').remove();
      this.inputs.imageClass.append('<option value="" selected="selected"></option>');

      for (var i = 0; i < classList.length; i++)
      {
        this.inputs.imageClass.append('<option value="' + classList[i]['class'] + '">' + (classList[i]['title'] || classList[i]['class']) + '</option>');
      }
    }
  },

  initDimmSelects: function ()
  {
    this.forbiddenExts = this.settings.forbidden_extensions.split(',');
    for (var i in this.forbiddenExts)
    {
      this.forbiddenExts[i] = $.trim(this.forbiddenExts[i].toLowerCase());
    }

    var dimOpts = '';
    if (this.settings.dimensions.length)
    {
		  var dims = this.settings.dimensions.split('~~').sort();
		  
		  for (var i = 0; i < dims.length; i++)
      {
        dims[i] = dims[i].split('|');
        var size = dims[i][0].split('x');
        dims[i][1] = $.trim(dims[i][1]);

        dimOpts += '<option value="' + dims[i][0] + '">' + (dims[i][1].length ? this.escapeHtml(dims[i][1]) + ' (' : '') + size[0] + ' &times; ' + size[1] + (dims[i][1].length ? ')' : '') + '</option>';
      }
		}

    var dimSelects = $('select[name^="insert[dimensions_"]');
    dimSelects.find('option[value!="custom"][value!="original"]').remove();
    dimSelects.prepend(dimOpts);
  },

  toggleRatioLock_thumb: function ()
  {
    this.ratioLock_thumb = this.ratioLock_thumb ? 0 : 1;
    var el = $('#ratioLock_thumb');
    if (this.ratioLock_thumb)
    {
      el.addClass('active');
      $('#insert_thumb_width').trigger('change');
    }
    else el.removeClass('active');

    $.cookie('plugoBrowser_ratioLock_thumb', this.ratioLock_thumb ? 1 : 0, {
      path: '/',
      expires: 1
    });
  },

  toggleRatioLock_full: function ()
  {

    this.ratioLock_full = this.ratioLock_full ? 0 : 1;
    var el = $('#ratioLock_full');
    if (this.ratioLock_full)
    {
      el.addClass('active');
      $('#insert_full_width').trigger('change');
    }
    else el.removeClass('active');

    $.cookie('plugoBrowser_ratioLock_full', this.ratioLock_full ? 1 : 0, {
      path: '/',
      expires: 1
    });
  },

  calculateRatio: function (el, force)
  {
    if (force || this.ratioLock_thumb == 1 || this.ratioLock_full == 1)
    {
      el = $(el);
      var value = el.val();

      if (force || this.ratioLock_thumb == 1)
      {
        if (el.attr('id') == 'insert_thumb_width') this.inputs.height_thumb.val(Math.round(value / this.selectedRatio));
        else if (el.attr('id') == 'insert_thumb_height') this.inputs.width_thumb.val(Math.round(value * this.selectedRatio));
      }

      if (force || this.ratioLock_full == 1)
      {
        if (el.attr('id') == 'insert_full_width') this.inputs.height_full.val(Math.round(value / this.selectedRatio));
        else if (el.attr('id') == 'insert_full_height') this.inputs.width_full.val(Math.round(value * this.selectedRatio));
      }
    }
  },

  //Inserting code to editor
  doInsert: function ()
  {
    var toInsert = '';

    if (this.insertMethod > 0)
    {
      if (this.settings.img_wrap_before) toInsert += this.settings.img_wrap_before;

      //overwrite by tuanmaster, because i just need the fullpath of file
      var url = this.encodeURIComponentNoSlash(this.getRealPath(this.settings.upload_dir) + '/' + this.selectedFile.relativePath);


      var thumbnailtext = "";
      if (this.insertMethod == 2)
      {

       

        //Added by tuanmaster2002@yahoo.com
        var manualWidth = this.inputs.manualwidth.val();
        var manualHeight = this.inputs.manualheight.val();

        if(parseInt(manualWidth) > 0)
          thumbnailtext += ' width="'+manualWidth+'" ';

        if(parseInt(manualHeight) > 0)
          thumbnailtext += ' height="'+manualHeight+'" ';

        /*
        var fullSize = this.inputs.dimm_full.val();
        if (fullSize == 'original') var url = this.encodeURIComponentNoSlash(this.getRealPath(this.settings.upload_dir) + '/' + this.selectedFile.relativePath);
        else
        {
          if (fullSize == 'custom')
          {
            if (!this.isInt(this.inputs.width_full.val())) this.calculateRatio(this.inputs.height_full[0], true);
            if (!this.isInt(this.inputs.height_full.val())) this.calculateRatio(this.inputs.width_full[0], true);
            
            if (!parseInt(this.inputs.width_full.val()) || !parseInt(this.inputs.height_full.val()))
            {
              this.showAlert(this.ed.getLang('plugobrowser_dlg.dimension_must_be_nonzero', 'Dimensions must be integer greater than 0'));
              return;
            }
            
            fullSize = [parseInt(this.inputs.width_full.val()), parseInt(this.inputs.height_full.val())];
          }
          else fullSize = fullSize.split('x');

          var url = this.encodeURIComponentNoSlash(this.getRealPath(this.settings.upload_dir)) + '/cache.php?src=/' + encodeURIComponent(this.selectedFile.relativePath) + '&w=' + fullSize[0] + '&h=' + fullSize[1];
          if (this.inputs.crop_full.attr('checked')) url += '&zc=1';
        }
        */

        var rel = $.trim(this.settings.img_rel);
        var title = $.trim(this.inputs.title.val());
        toInsert += '<a href="' + url + '"' + (title.length ? ' title="' + this.escapeHtml(title) + '"' : '') + (rel ? ' rel="' + rel + '"' : '') + '>';
      }

      

      

      /*
      var thumbSize = this.inputs.dimm_thumb.val();
      if (thumbSize == 'original') var url = this.encodeURIComponentNoSlash(this.getRealPath(this.settings.upload_dir) + '/' + this.selectedFile.relativePath);
      else
      {
        if (thumbSize == 'custom')
        {
          if (!this.isInt(this.inputs.width_thumb.val())) this.calculateRatio(this.inputs.height_thumb[0], true);
          if (!this.isInt(this.inputs.height_thumb.val())) this.calculateRatio(this.inputs.width_thumb[0], true);
          
          if (!parseInt(this.inputs.width_thumb.val()) || !parseInt(this.inputs.height_thumb.val()))
            {
              this.showAlert(this.ed.getLang('plugobrowser_dlg.dimension_must_be_nonzero', 'Dimensions must be integer greater than 0'));
              return;
            }
          
          thumbSize = [parseInt(this.inputs.width_thumb.val()), parseInt(this.inputs.height_thumb.val())];
        }
        else thumbSize = thumbSize.split('x');

        var url = this.encodeURIComponentNoSlash(this.getRealPath(this.settings.upload_dir)) + '/cache.php?src=/' + encodeURIComponent(this.selectedFile.relativePath) + '&w=' + thumbSize[0] + '&h=' + thumbSize[1];
        if (this.inputs.crop_thumb.attr('checked')) url += '&zc=1';
      }
      */

      var imageClass = $.trim(this.inputs.imageClass.val());
      toInsert += '<img alt="' + this.escapeHtml(this.inputs.alt.val()) + '" '+thumbnailtext+' src="' + url + '"' + (imageClass ? ' class="' + imageClass + '"' : '') + ' />';

      if (this.insertMethod == 2) toInsert += '</a>';
      if (this.settings.img_wrap_after) toInsert += this.settings.img_wrap_after;
    }
    else
    {
      var anchorTitle = this.inputs.anchorTitle.val();
      if (!anchorTitle.length)
      {
        this.showAlert(this.ed.getLang('plugobrowser_dlg.fill_link_title', 'Please fill in link title'));
        return;
      }

      if (this.settings.file_wrap_before) toInsert += this.settings.file_wrap_before;
      var title = $.trim(this.inputs.fileTitle.val());
      var insFsize = this.inputs.insertFilesize.attr('checked');
      var insExt = this.inputs.insertExt.attr('checked');

      var props = (insFsize || insExt) ? ' ' + this.settings.link_props_pattern.replace('FILE_PROPERTIES', ((insExt ? this.selectedFile.extension.toUpperCase() : '') + (insFsize ? (insExt ? ', ' : '') + this.selectedFile.size : ''))) : '';

      toInsert += '<a href="' + this.getRealPath(this.settings.upload_dir) + '/' + this.selectedFile.relativePath + '"' + (title ? ' title="' + this.escapeHtml(title) + '"' : '') + '>' + this.escapeHtml(anchorTitle) + '</a>' + props;

      if (this.settings.file_wrap_after) toInsert += this.settings.file_wrap_after;
    }

    tinyMCEPopup.editor.execCommand('mceInsertContent', false, toInsert);
    tinyMCEPopup.close();
  },

  //Uploader init
  initUploader: function ()
  {
    this.uploader = new plupload.Uploader(
    {
      runtimes: 'gears,html5,flash,silverlight,browserplus',
      browse_button: 'upload_pickFiles',
      container: 'upload_container',
      max_file_size: '100M',
      chunk_size: this.maxUploadSize,
      url: 'ajax/upload.php',
      //resize : {width : 320, height : 240, quality : 90},
      flash_swf_url: 'plupload/plupload.flash.swf',
      silverlight_xap_url: 'plupload/plupload.silverlight.xap',

      multipart_params: {
        'path': '/'
      }
    });

    this.uploader.bind('FilesAdded', function (up, files)
    {
      PlugoBrowser.closePopupDisabled = true;

      $.each(files, function (i, file)
      {
        var pos = file.name.lastIndexOf('.');
        var ext = (pos != -1) ? file.name.substring(pos + 1, file.name.length) : file.name;

        if ($.inArray(ext, PlugoBrowser.forbiddenExts) != -1)
        {
          PlugoBrowser.showAlert(PlugoBrowser.ed.getLang('plugobrowser_dlg.forbidden_extension', 'You are trying to upload file with forbidden extension'));
          PlugoBrowser.uploader.removeFile(file);
          return;
        }

        $('#upload_fileList').append('<div id="' + file.id + '"><div style="line-height: 16px; height: 16px; margin-bottom: 4px;"><a href="#" class="remove" style="float:left; margin-right:7px;" title="' + PlugoBrowser.ed.getLang('plugobrowser_dlg.remove', 'Remove') + '"><img src="css/delete.png" width="16" height="16" alt="" /></a><span class="f-left">' + PlugoBrowser.escapeHtml(file.name) + ' (' + plupload.formatSize(file.size) + ')</span><strong style="float:right;"></strong></div><div class="progress progress-striped active"><div class="bar"></div></div></div>');

        $('#' + file.id + ' a.remove').click(function ()
        {
          PlugoBrowser.uploader.removeFile(file);
          $('#' + file.id).remove();
          return false;
        });
      });

      PlugoBrowser.positionPopup();

      window.setTimeout(function ()
      {
        PlugoBrowser.closePopupDisabled = false;
      }, 500);

      up.refresh();
    });

    this.uploader.bind('UploadProgress', function (up, file)
    {

      var fileCont = $('#' + file.id);
      if (fileCont.hasClass('uploadError')) return;
      else
      {
        fileCont.find('.remove').hide();
        fileCont.find('strong').html(file.percent + '%');
        fileCont.find('.bar').css('width', file.percent + '%');;
      }
    });

    this.uploader.bind('BeforeUpload', function (up, file)
    {
      PlugoBrowser.uploadResult = true;
    });

    this.uploader.bind('FileUploaded', function (up, file, response)
    {
      response = jQuery.parseJSON(response.response);

      if (!response.result)
      {
        $('#' + file.id).addClass('uploadError');
        PlugoBrowser.uploadResult = false;
      }

      $('#' + file.id + " .progress").removeClass("active").addClass("progress-success");
      $('#' + file.id + " strong").html(response.result ? '100%' : PlugoBrowser.ed.getLang('plugobrowser_dlg.upload_error', 'Error'));
      $('#' + file.id).delay(1000).slideUp();
    });

    this.uploader.bind('UploadComplete', function (up, files)
    {
      PlugoBrowser.closePopupDisabled = false;
      if (PlugoBrowser.uploadResult)
      {
        PlugoBrowser.readDir($('#upload_path').val());
        PlugoBrowser.hidePopup();
      }
    });

    this.uploader.bind('Error', function (up, err)
    {
      if (err.code == -600) var msg = PlugoBrowser.ed.getLang('plugobrowser_dlg.max_file_size', 'Maximum uploaded file size is') + ' ' + Math.round(up.settings.max_file_size / 1024 / 1024) + 'MB';
      else var msg = err.message + (err.file ? ', File: ' + err.file.name : '');

      PlugoBrowser.showAlert(msg);
      $('#' + err.file.id).remove();
      up.refresh();
    });

    this.uploader.init();
  },

  upload: function ()
  {
    if (this.uploader.files.length > 0)
    {
      var pathInput = $('#upload_path');
      this.closePopupDisabled = true;
      pathInput.attr('disabled', 'disabled');

      $('#upload_links').slideUp(500, function ()
      {
        $(this).remove();
      });

      this.uploader.settings.multipart_params.path = pathInput.val();
      this.uploader.start();
    }
  },

  //About form
  showAbout: function ()
  {
    this.showPopup('<p><strong>Author</strong>: Plugo s.r.o.<br /><strong>Version</strong>: 1.0.0<br /><strong>Terms &amp; Conditions</strong>: <a href="http://www.plugobrowser.com/terms/" onclick="window.open(this.href); return false;">www.plugobrowser.com/terms/</a><br /><br />Visit more projects from our lab: <a href="http://www.plugolabs.com/" onclick="window.open(this.href); return false;">www.plugolabs.com</a></p>', null, this.ed.getLang('plugobrowser_dlg.about', 'About'));
  },

  bindHovers: function (el)
  {
    el.find('.menu_item').mouseenter(function ()
    {
      $(this).addClass('active');
    }).mouseleave(function ()
    {
      $(this).removeClass('active');
    });
  },

  getTimezoneList: function ()
  {
    return {
      '-12': 'International Date Line West',
      '-11': 'Midway Island Samoa',
      '-10': 'Hawaii',
      '-9': 'Alaska',
      '-8': ['Pacific Time (US & Canada)', 'Tijuna, Baja California'],
      '-7': ['Arizona', 'Chihuahua, La Paz, Mazatlan', 'Mountain Time (US & Canada)'],
      '-6': ['Central America', 'Central Time (US & Canada)', 'Guadalajara, Mexico City, Monterrey', 'Saskatchewan'],
      '-5': ['Bogota, Lima, Quito, Rio Branco', 'Eastern Time (US & Canada)', 'Indiana (East)'],
      '-4': ['Atlantic Time (Canada)', 'Caracas, La Paz', 'Manaus', 'Santiago'],
      '-3.5': 'Newfoundland',
      '-3': ['Brazilia', 'Buenos Aires, Georgtown', 'Greenland', 'Montevideo'],
      '-2': 'Mid-Atlantic',
      '-1': ['Azores', 'Cape Verde Is.'],
      '0': ['Casablanka, Monrovia, Reykjavik', 'GMT: Dublin, Edinburgh, Lisbon, London'],
      '1': ['Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna', 'Belgrade, Bratislava, Budapest, Ljubljana, Prague', 'Brussels, Copenhagen, Madrid, Paris', 'Sarajeva, Skopje, Warsaw, Zagreb', 'West Central Africa'],
      '2': ['Amman', 'Athens, Bucharest, Istanbul', 'Beriut', 'Cario', 'Harare, Pretoria', 'Helsinki, Kyiv, Rig, Sofia, Tallin, Vilnius', 'Jerusalem', 'Minsk', 'Windhoek'],
      '3': ['Baghdad', 'Kuwait, Riyadh', 'Moscow, St. Petersburg, Volgograd', 'Nairobi', 'Tbilisi', 'Tehran'],
      '4': ['Abu Dhabi, Muscat', 'Baku', 'Yerevan', 'Kabul'],
      '5': ['Ekaterinburg', 'Islamabad, Karachi, Tashkent'],
      '5.5': ['Chennai, Kolkata, Mumbai, New Delhi', 'Sri Jayawardenepura'],
      '5.75': 'Kathmandu',
      '6': ['Almaty, Novosibirsk', 'Astana, Dhaka'],
      '6.5': 'Yangon (Rangoon)',
      '7': ['Bangkok, Hanoi, Jakarta', 'Krasnoyarsk'],
      '8': ['Beijing, Chongping, Hong Kong, Urmaqi', 'Irkutsk, Ulaan Bataar', 'Kuala Lumpur, Singapore', 'Perth', 'Taipei'],
      '9': ['Osaka, Sapporo, Tokyo', 'Seoul', 'Yakutsk'],
      '9.5': ['Adelaide', 'Darwin'],
      '10': ['Brisbane', 'Canberra, Melbourne, Sydney', 'Guam, Port Moresby', 'Hobart, Vladivostok'],
      '11': 'Magadan, Solomon Is., New Caledonia',
      '12': ['Auckland, wellington', 'Fiji, Kamchatka, Marshall Is.'],
      '13': 'Nuku\'alofa'
    };
  }
}

tinyMCEPopup.onInit.add(PlugoBrowser.init, PlugoBrowser);