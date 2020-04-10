/**
 * editor_plugin.js
 *
 * Copyright 2012, Plugo s.r.o.
 *
 * @license: http://www.plugobrowser.com/license/
 */

(function()
{		  
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('plugobrowser');
	tinymce.create('tinymce.plugins.PlugoBrowserPlugin',
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
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mcePlugobrowser');
			ed.addCommand('mcePlugobrowser', function()
			{
				ed.windowManager.open(
			  	{
		  			file : url + '/dialog.php',
	  				width : 968 + parseInt(ed.getLang('plugobrowser.delta_width', 0)),
  					height : 600 + parseInt(ed.getLang('plugobrowser.delta_height', 0)),
					  inline : 0,
				  	maximizable : 1,
            popup_css : false
		  		},
	  			{
  					plugin_url : url // Plugin absolute URL
				  }
				);
			});

			// Register plugobrowser button
			ed.addButton('plugobrowser',
			{
				title : 'plugobrowser.desc',
				cmd : 'mcePlugobrowser',
				image : url + '/img/plugobrowser.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n)
			{
				cm.setActive('plugobrowser', n.nodeName == 'IMG');
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
				longname 	: 'PlugoBrowser',
				author 		: 'Plugo s.r.o.',
				authorurl : 'http://www.plugo.cz',
				infourl 	: 'http://www.plugobrowser.com',
				version 	: '1.0'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('plugobrowser', tinymce.plugins.PlugoBrowserPlugin);
})();