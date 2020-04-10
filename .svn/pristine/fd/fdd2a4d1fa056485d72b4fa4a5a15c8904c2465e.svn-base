/**
 * editor_plugin.js
 *
 * Copyright 2012, Dienmay Corp
 *
 * @license: http://www.dienmay.com/license/
 */

(function()
{		  
	// Load plugin specific language pack
	//tinymce.PluginManager.requireLangPack('dmfilemanager');
	tinymce.create('tinymce.plugins.DmFileManagerPlugin',
	{
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url)
		{
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceDmfilemanager');
			ed.addCommand('mceDmfilemanager', function()
			{
				ed.windowManager.open(
			  	{
		  			file : rooturl + 'profile/file',
	  				width : 968,
  					height : 600,
					  inline : 0,
				  	maximizable : 1,
            		popup_css : false
		  		},
	  			{
  					plugin_url : rooturl + 'profile/file' // Plugin absolute URL
				  }
				);
			});

			// Register dmfilemanager button
			ed.addButton('dmfilemanager',
			{
				cmd : 'mceDmfilemanager',
				image : url + '/dmfilemanager.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n)
			{
				cm.setActive('dmfilemanager', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm)
		{
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function()
		{
			return {
				longname 	: 'DmFileManager',
				author 		: 'Vo Duy Tuan',
				authorurl : 'http://bloghoctap.com/',
				infourl 	: 'http://www.bloghoctap.com',
				version 	: '1.0'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('dmfilemanager', tinymce.plugins.DmFileManagerPlugin);
})();