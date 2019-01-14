var PrisnaYWTAdmin = {

	_tabs: {
		general: null,
		advanced: null
	},
	
	_form: null,
	_action: null,
	_buttons: {},
	
	_visual: {},
	
	_headings: {},
	
	_fields: {
		general: {},
		advanced: {}
	},
	
	initialize: function() {
		
		if (typeof PrisnaYWTCommon == "undefined") {
			setTimeout(function() {
				PrisnaYWTAdmin.initialize();
			}, 200);
			return;
		}

		PrisnaYWTAdmin._initialize_elements();
		PrisnaYWTAdmin._initialize_tooltips();
		PrisnaYWTAdmin._initialize_headings();
		PrisnaYWTAdmin._initialize_visual_fields();
		PrisnaYWTAdmin._initialize_languages();
		PrisnaYWTAdmin._initialize_tabs();

		PrisnaYWTAdmin._initialize_dependences();
		
		PrisnaYWTCommon.clickSelected("#section_prisna_style_inline");
		
	}, 
	
	_initialize_tabs: function() {
		
		jQuery(".prisna_ywt_ui_tab_unselected").removeClass("prisna_ywt_hidden_important");
		
		this._tabs.general = new PrisnaYWTCommon.Tabs();

		this._tabs.general.registerTab("general", PrisnaYWTAdmin._on_tab_change);
		this._tabs.general.registerTab("advanced", PrisnaYWTAdmin._on_tab_change);
		this._tabs.general.registerTab("premium", PrisnaYWTAdmin._on_tab_change);

		this._on_tab_change(this._tabs.general.getSelected());
		
		this._tabs.advanced = new PrisnaYWTCommon.Tabs(2);

		this._tabs.advanced.registerTab("advanced_general");
		this._tabs.advanced.registerTab("advanced_import_export");

	},

	_on_tab_change: function(_param) {
		
		PrisnaYWTAdmin._show_buttons(_param != "premium");
		
	},

	_show_buttons: function(_state) {
		
		if (_state) {
			this._buttons.save.show();
			this._buttons.reset.show();
		}
		else {
			this._buttons.save.hide();
			this._buttons.reset.hide();
		}
		
	},

	_initialize_elements: function() {
	
		this._form = PrisnaYWTCommon.$("prisna_admin");
		this._action = PrisnaYWTCommon.$("prisna_ywt_admin_action");

		this._fields.general.display_mode = jQuery("#prisna_display_mode");
		this._fields.general.style_inline = jQuery("#section_prisna_style_inline input");
		this._fields.general.show_flags = jQuery("#section_prisna_show_flags input");
		this._fields.general.languages = jQuery("#section_prisna_languages input");

		this._buttons.save = jQuery(".button-primary");
		this._buttons.reset = jQuery(".reset-settings");

	},
	
	_initialize_dependences: function() {	

		PrisnaYWTCommon.Dependencies.add(this._fields.general.show_flags, "click", function() {

			PrisnaYWTAdmin.showSection("section_prisna_languages", this.value == "true");
			PrisnaYWTAdmin.showSection("section_prisna_languages_order", this.value == "true");
			
		});
	
	},
	
	_initialize_headings: function() {
		
		var headings = jQuery(".prisna_ywt_heading");
		for (var i=0; i<headings.length; i++)
			PrisnaYWTAdmin._headings[headings[i].id] = new PrisnaYWTCommon.Heading(headings[i]);

	},
	
	_initialize_visual_fields: function() {
		
		var fields = jQuery(".prisna_ywt_visual input");
		for (var i=0; i<fields.length; i++)
			if (fields[i].checked)
				this._visual[fields.eq(i).attr("name")] = fields[i].value;
		
		jQuery(".prisna_ywt_visual input").click(function() {

			var checkbox = jQuery(this);
			
			checkbox.parents(".prisna_ywt_visual").find(".prisna_ywt_field").removeClass("prisna_ywt_visual_checked");
			checkbox.parents(".prisna_ywt_field").addClass("prisna_ywt_visual_checked");

		});
		
	},
		
	_initialize_languages: function() {

		var sorter = jQuery("#section_prisna_languages_order ul.prisna_ywt_language_order_group");
	
		sorter.dragsort({
			dragBetween: true,
			placeHolderTemplate: '<li class="prisna_ywt_language_order_item prisna_ywt_language_place_holder"></li>',
			dragEnd: this._languages_order_update
		});
	
		this._fields.general.languages.click(function() {
			
			PrisnaYWTAdmin._languages_update(this);
			
		});
		
	},
	
	adjustPost: function(_event, _element) {
		
		if (event.which == 13 || event.keyCode == 13)
			return false;
		
		if (!_element)
			return true;
		
		var target = PrisnaYWTCommon.$(_element.id + "_post");
		var ini = _element.value.indexOf("?") != -1 ? "&" : "?";
		
		target.innerHTML = target.innerHTML.replace(/^(\?|\&amp\;)/, ini);
		
		return true;
		
	},
	
	setLanguageLite: function(_data) {
	
		var select = this._fields.translations.languages.get(0);
		select.options.length = 0;
				
		var data = [{ 
			text: '',
			value: '' 
		}];

		for (var i in _data)
			data.push({
				text: i,
				value: _data[i].file
			});

		for(var i=0; i < data.length; i++)
			select.options.add(new Option(data[i].text, data[i].value));
		
	},
	
	_languages_update: function(_checkbox) {

		if (_checkbox.checked) {
			
			var container = jQuery(_checkbox).parents(".prisna_ywt_language_item");
			var item = container.find(".prisna_ywt_language_order_item").clone(false);
			item.attr("id", "prisna_ywt_language_order_item_" + _checkbox.value);
		
			var sorter = jQuery("#section_prisna_languages_order ul.prisna_ywt_language_order_group");
			sorter.append(item);
			
		}
		else
			jQuery("#prisna_ywt_language_order_item_" + _checkbox.value).remove();
		
		this._languages_order_update();
		
	},
	
	_languages_order_update: function() {
		
		var result = [];
		var target = jQuery("#prisna_languages_order");
		var items = jQuery("#section_prisna_languages_order ul.prisna_ywt_language_order_group input");
		for (var i=0; i<items.length; i++)
			result.push(items[i].value);
		target.val(result.join(","));
		
	},
	
	_initialize_tooltips: function() {
		
		PrisnaYWTCommon.initializeTooltip(".prisna_ywt_tooltip");
		
	},
	
	showSection: function(_section_id, _state, _now) {
		
		if (_now === true) {
			if (_state)
				jQuery("#" + _section_id).show();
			else
				jQuery("#" + _section_id).hide();
		}
		else {
			if (_state)
				jQuery("#" + _section_id).slideDown("fast");
			else
				jQuery("#" + _section_id).slideUp("fast");
		}
		
	},
	
	submitSettings: function() {
		
		this._form.submit();
		
	},
	
	resetSettings: function(_message) {
	
		if (confirm(_message)) {
			this._action.value = "prisna_ywt_reset_settings";
			this._form.submit();
			return true;
		} 

		return false;
		
	},
	
	hideMessage: function(_selector, _delay) {
		
		setTimeout(function() {
			jQuery(_selector).animate({
				opacity: "toggle",
				height: "toggle"
			}, "fast")
		}, _delay);
		
	}

};