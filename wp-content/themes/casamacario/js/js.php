<script type="text/javascript">// <![CDATA[
"use strict";

var $,$window,ajax_GF,alert;
var iniciada = false;

$window = jQuery(window);
/*ERRROR GAFA--------------------------------------------------------------------*/
var elementoErrorGF = '.gafa-mensaje,.gafa-error';var errorGafa=function(texto, clase){ clearTimeout(timer); jQuery(elementoErrorGF).remove(); switch(clase){ case 'inicio': if(jQuery(elementoErrorGF).length==0){ jQuery('body').append('<div class="gafa-mensaje" style="top:0px"><h1>Procesando...</h1></div>'); }; break; case 'fijo': if(jQuery(elementoErrorGF).length==0){ jQuery('body').append('<div class="gafa-mensaje" style="top:0px"><h1>Notificación</h1>'+texto+'</div>'); }; break; case 'conexion': return; jQuery('body').append('<div class="gafa-error"><h1>Error de conexión</h1>Lo sentimos, algo hicimos mal. Inténtalo en 15 minutos.</div>'); funcionElementoError(); break; default: var classe=clase; if(clase==undefined||clase==''){ classe='error'; }; if( classe=='error' ){ texto= '<h1>¡Alerta!</h1>'+texto; }else{ texto= '<h1>Notificación</h1>'+texto; }; jQuery('body').append('<div class="gafa-'+classe+'">'+texto+'</div>'); funcionElementoError(); break; };};alert=errorGafa;var timer;var funcionElementoError= function(){ if (jQuery(elementoErrorGF).length!=0){ jQuery(elementoErrorGF).animate({top:0},500); jQuery(elementoErrorGF).attr('title','Elimina este mensaje'); timer= setTimeout(function(){ if(jQuery(elementoErrorGF).length!=0){ jQuery(elementoErrorGF).fadeOut('fast',function(){ jQuery(elementoErrorGF).remove(); }); }; },8000); };};jQuery(document).ready(function(){ jQuery('body').on('click',elementoErrorGF,function(){ jQuery(elementoErrorGF).fadeOut('slow',function(){ jQuery(elementoErrorGF).remove(); clearTimeout(timer); }); });});
/*ERRROR GAFA FIN--------------------------------------------------------------------*/
/*PREGUNTA GAFA--------------------------------------------------------------------*/
function crear_pregunta( texto,info,callback,legal, false_function, data_false ){ cargando(); if( !legal ){ legal = ''; }; if( !$('#pregunta_gafa').length ){ $('#pregunta_gafa').remove(); }; $('body').append('<div id="pregunta_gafa">'+texto+'<br/><div id="aceptar_pregunta_gafa" class="boton">Aceptar</div><div id="cancelar_pregunta_gafa" class="boton">Cancelar</div><br/><small>'+legal+'</small></div>'); /*ACEPTAR*/ $('#aceptar_pregunta_gafa').one('click',function(){ $('#pregunta_gafa').remove(); borrarCargando(); callback( info ); }); /*CANCELAR*/ $('#cancelar_pregunta_gafa').one('click',function(){ $('#pregunta_gafa').remove(); if( false_function ){ false_function( data_false ); }; borrarCargando(); }); };
/*PREGUNTA GAFA FIN--------------------------------------------------------------------*/
/*CARGANDO GAFA--------------------------------------------------------------------*/
function cargando(id){ if(id){ if($('#'+id).length<1){ $('body').append('<div id="'+id+'" class="cover" style="display:none;"></div>'); $('#'+id).fadeIn(); }; }else{ if($('#cargando').length<1){ $('body').append('<div id="cargando" class="cover" style="display:none;"></div>'); $('#cargando').fadeIn(); }; }; }; function borrarCargando(id){ if(id){ if($('#'+id).length>=0){ $('#'+id).fadeOut('fast',function(){ $('#'+id).remove(); }); }; }else{ if($('#cargando').length>=0){ $('#cargando').fadeOut('fast',function(){ $('#cargando').remove(); }); }; }; };
/*CARGANDO GAFA FIN--------------------------------------------------------------------*/

// #REGION: GAFA PLUGINS

/**
 * Converts <select>/<option> elements into <div> or any other kind of html elements.
 *
 * Important. Your <select> elements must have the attributes "id" and "name" and the <option> elements must contain the "value" attribute.
 *
 * Usage: This code is quite simple to use, check out this example.
 *
 * <code>
 *     // Converts all the selects in the page into <div>'s.
 *     SelectsToElements("select", null, function(originalSelect){
	 *          $(originalSelect).attr("hidden","");
	 *      });
 * </code>
 *
 * <glossary>
 *     dived: Whenever I say "dived", I mean the converted version of a <select> or <option> element, into divs or any other html element (span, ul, li, etc).
 *     folded: The "folded" element is the div (or other element) that displays the currently selected option. // TODO: Rename this word to preview or selected.
 * </glossary>
 *
 * @param selectSelector a CSS selector to select the original <select> elements.
 * @param settings customize how to convert the <select> elements into other type of elements.
 * @param whatToDoWithOriginalSelect callback that is passed the original <select> DOM element when the conversion finishes. Useful if you want, for instance, hide, the original element.
 * @constructor
 */
function SelectsToElements(selectSelector, settings, whatToDoWithOriginalSelect)
{
	// TODO: Add support for element <optgroup>.
	// TODO: Listen to the events "addClass" and "removeClass" of the original elements, so when their clases are modified, the dived version's classes get updated too. I think it there might be more jquery events we should be listening to.
	// TODO: Add keyboard (arrow keys) functionality. Down/Enter to fold out the widget, SpaceBar/Enter to select a value.
	// TODO: If a dived <select> is open, and we click another one, the prviously opened should be closed.
	// TODO: In the dived <select>, save a "data-" with the id of the original <select>.
	// TODO: Add support to store the "data-"'s and the rest of attributes of the <select>/<option>'s.
	// TODO: If a click on a disabled dived <option> was made, the foldout toggle must not work.
	// TODO: This must work backwardly, that is, when the actual original <select> is updated, the value of the "folded" element must be updated. I should subscribe to the original <select> events, but don't rely on them, because the original ones might be deleted by the user in the callback of the function. Also, this widget must provide an event API, with only the "onchange" event. NOTE: Don't worry about this as long as you don't delete the original <select> elements, just hide them.
	// TODO: Add a class for the currently selected dived <option> elements, so they can be highlighted whenever the widget is folded out.

	$(selectSelector).each(function(i, value)
	{
		// ----- SETTINGS START

		// TODO: Make it possible to receive an args variable where to customize these settings.

		var idPrefixForDivedSelect = "dived-";
		var commonClassForDivedSelect = "dived-select";
		var commonClassForDivedOption = "dived-option";
		var divedElementForSelect = "div";
		var divedElementForOption = "div";
		var conserveOriginalSelectClasses = true; // Nota: Debería ser siempre true para preservar las clases de los <select>.

		/**
		 * If true, the dived <select>'s container (the whole widget) will be placed after the original <select>. Else, it will be placed before it.
		 */
		var putAfter = true;

		/**
		 * Class to put to the container element of the dived <select> when the widget is folded down, if this class is not present, the widget is folded up.
		 * @type {string}
		 */
		var foldedDownClass = "folded-down";

		var selectedOptionClass = "dived-option-selected";

		// ----- SETTINGS END

		// Get the <select> element.

		var $originalSelect = $(value);

		// Get/generate the id of the <select> element.

		var originalSelectId = $originalSelect.attr("id");
		if(typeof(originalSelectId) == 'undefined' || originalSelectId == false)
		{
			console.log("Warning: The <select name='" + $originalSelect.attr('name') + "'> element has not an id. You must specify an unique id for all the <select> elements you want to convert.");
			// If the <select> has not an id, generate one random id.
			originalSelectId = Math.random().toString(36).substring(2).replace(" ", "-");
		}

		// Get the class of the <select> element.

		var originalSelectClass = $originalSelect.attr("class");
		if(typeof(originalSelectClass) == 'undefined' || originalSelectClass == false) originalSelectClass = "";

		// Id for the dived <select>.

		var divedSelectId = idPrefixForDivedSelect + originalSelectId;

		// Create the alternative <select>.

		var $divedSelect = $originalSelect.parent().append(
			'<' + divedElementForSelect + ' ' +
			'id="' + divedSelectId + '"' +
			'class="' + commonClassForDivedSelect + ' "' +
			'data-name="' + $originalSelect.attr("name") + '"' +
				// TODO: Maybe we need to loop throughout all the attributes of the <select> with $.attrs().
			'></' + divedElementForSelect + '>');

		// Extract the <element> from the the newly generated code. Note that <element> might be any html element, like a div, span, etc.
		// TODO: This code is not strong enough because it requires the original <select>'s to have an unique "id", otherwise, this code might work unexpectedly.
		$divedSelect = $divedSelect.find("#" + divedSelectId);

		// Create the alternative <option>'s.

		var selectedOptionText = "";
		var selectedOptionIndex = -1;

		$originalSelect.children('option').each(function(optionIndex)
		{
			// Get the class attribute of the <option> element.
			var originalOptionClass = $(this).attr("class");
			if(typeof(originalOptionClass) == 'undefined' || originalOptionClass == false) originalOptionClass = "";

			var isTheSelectedOption = optionIndex == 0 || this.selected;

			if(isTheSelectedOption)
			{
				selectedOptionText = $(this).html();
				selectedOptionIndex = optionIndex;
			}

			$divedSelect.append(
				'<'+divedElementForOption+' ' +
				'data-value="' + this.value + '"' +
				'class="' + originalOptionClass + " " + commonClassForDivedOption + '"' +
				(this.selected ? "data-selected " : "") + // Note: Don't use just the word "selected" because it might not work well in all browsers since not all the html elements have as valid that attribute.
				(this.disabled ? "data-disabled " : "") + // Note: Don't use just the word "disabled" because it might not work well in all browsers since not all the html elements have as valid that attribute.
				'>'+$(this).html()+'</'+divedElementForOption+'>');
		});

		console.log("Index of the selected option: " + selectedOptionIndex);

		// Get the <option> elements.

		var $divedOptions = $divedSelect.find("." + commonClassForDivedOption);

		// Add a class to the dived selected <option> so it can be highlighted.

		if($divedOptions.length >= 1) $($divedOptions.get(selectedOptionIndex)).addClass(selectedOptionClass);

		// Move the dived <select> and <option>'s into a container.

		var containerId = divedSelectId + "-ctn";
		var containerClass = "dived-select-ctn";
		if(conserveOriginalSelectClasses)
		{
			containerClass += " " + originalSelectClass;
		}

		var containerHtml = "<div id='" + containerId + "' class='" + containerClass + "'></div>";
		$divedSelect.append(containerHtml);
		var $container = $divedSelect.find("#" + containerId).first();
		$container.parent().parent().append($container);
		$container.append($divedSelect);

		// Create a "folded" element. That will be used to show the dived <select> when it's not folded out.

		var foldedId = divedSelectId + "-folded";
		var foldedHtml = "<div id='"+foldedId+"' class='dived-select-folded'>"+selectedOptionText+"</div>"; // TODO: Get what element is the currently default. It't the first one in the options, or the last one with the selected attribute on it.
		$container.prepend(foldedHtml);
		var $folded = $container.find("#" + foldedId);

		if(putAfter)
		{
			$originalSelect.after($container);
		}
		else
		{
			$originalSelect.before($container);
		}
		/*
		 var masterContainerHtml = "<div id='"+foldedId+"-master' class='grupo-select'></div>";
		 $container.after(masterContainerHtml);
		 var $masterContainer = $container.parent().find("#" + foldedId + "-master");
		 $masterContainer.parent().parent().append($masterContainer);
		 $masterContainer.prepend($originalSelect)
		 */

		/**
		 * Will be called whenever the widget is clicked.
		 */
		function toggleIt()
		{
			$container.toggleClass(foldedDownClass);
		}

		// When a "folded" element is clicked, the dived <select> will toggle.

		$container.click(toggleIt);

		/**
		 * Representa un rectángulo con valores para top, left, bottom y right.
		 */
		function Rect()
		{
			this.top = 0;
			this.left = 0;
			this.bottom = 0;
			this.right = 0;

			/**
			 * Regresa true si las coordenadas dadas por los 'x' y 'y' están adentro del rectángulo.
			 * @return bool
			 */
			this.IsInside = function(x, y)
			{
				return !this.IsOutside(x, y);
			};

			/**
			 * Regresa true si las coordenadas dadas por los 'x' y 'y' están afuera del rectángulo.
			 * @return bool
			 */
			this.IsOutside = function(x, y)
			{
				return (x < this.left || x > this.right || y > this.bottom || y < this.top);
			};
		}

		/**
		 * Consigue un objeto Rect que contiene las coordenadas globales de un elemento.
		 */
		function GetRect(element)
		{
			var $container = $(element);
			var offset = $container.offset();
			var rect = new Rect();
			rect.top = offset.top;
			rect.left = offset.left;
			rect.right = $container.width() + rect.left;
			rect.bottom = $container.height() + rect.top;
			return rect;
		}

		// A click anywhere, will fold up all the dived <select>'s as long as the click was not made on a folded up element.

		$(window).click(function(e){
			var didClickInside = GetRect($container).IsInside(e.clientX, e.clientY);
			//if(!didClickInside) $container.removeClass(foldedDownClass); // TODO: Esta linea debe estar descomentada, pero en la pagina de comunidad-bien-para-bien, da problemas.
		});

		// When a dived <option> is clicked (OnOptionClicked).

		$divedOptions.click(function()
		{
			var $option = $(this);

			var isDisabled = $option.attr("data-disabled");

			if(typeof(isDisabled) != 'undefined' || isDisabled == false)
			{
				//console.log($option.html() + " is disabled.");
				return;
			}

			// A click on a dived <option> will update the value of the "folded" element.

			$folded.html($(this).html());

			// Update the "selected" class in the dived <options>.
			$divedOptions.removeClass(selectedOptionClass);
			$(this).addClass(selectedOptionClass);

			// Set the value of the clicked element to the original <select> and trigger the "change" event on the original <select>.

			$originalSelect.val($option.data("value")).trigger("change");
		});


		// If a value for whatToDoWithOriginalSelect was defined, call that callback and pass the original <select> as parameter.

		if(typeof(whatToDoWithOriginalSelect) != 'undefined' && typeof(whatToDoWithOriginalSelect) != false)
		{
			whatToDoWithOriginalSelect(value);
		}
	});
}


/**
 * Representa un rectángulo con valores para top, left, bottom y right.
 */
function Rect()
{
	this.top = 0;
	this.left = 0;
	this.bottom = 0;
	this.right = 0;

	/**
	 * Regresa true si las coordenadas dadas por los 'x' y 'y' están adentro del rectángulo.
	 * @return bool
	 */
	this.IsInside = function(x, y)
	{
		return !this.IsOutside(x, y);
	};

	/**
	 * Regresa true si las coordenadas dadas por los 'x' y 'y' están afuera del rectángulo.
	 * @return bool
	 */
	this.IsOutside = function(x, y)
	{
		return (x < this.left || x > this.right || y > this.bottom || y < this.top);
	};
}

/**
 * Consigue un objeto Rect que contiene las coordenadas globales de un elemento html.
 *
 * Uso:
 * <code>
 * 		var didClickInside = GetRect(htmlElement).IsInside(e.clientX, e.clientY);
 * </code>
 */
function GetRect(element)
{
	var $container = $(element);
	var offset = $container.offset();
	var rect = new Rect();
	rect.top = offset.top;
	rect.left = offset.left;
	rect.right = $container.width() + rect.left;
	rect.bottom = $container.height() + rect.top;
	return rect;
}

// #ENDREGION: GAFA PLUGINS

jQuery(document).ready(function(){
	$ = jQuery;
	
	$('[data-link]').on('click',function(){
		document.location.href = $(this).data('link');
	});
	$('body').on('click','[data-accion]',function( e ){
		if( $(this).is('.viendo') || $(this).is('.usando') ){ return; };
		
		if( $(e.target).closest('[data-accion]').length ){ e.stopPropagation(); };
		
		if( ajax_GF ){
			ajax_GF.abort();
		};
		
		var data		= $(this).data();
		
		/*RESETEO DEL MENU*/
		$('.viendo').removeClass('viendo');/*REALMENTE EN QUÉ ESTAMOS*/
		$(this).closest('.padre_de_ajax').find('.usando').removeClass('usando');/*HERMANOS AL MISMO NIVEL*/
		
		$(this).addClass('viendo').addClass('usando');
		
		if( es_funcion_js( data ) ){ return; };
		
		
		do_proceso( data.accion, '#'+data.recipiente );
	});
	
	
	/*INICIO*/
	$window.resize(configurar_Web);
	iniciar_Web();
	
	
	function es_funcion_js( data ){
		if( !data ){ return true; };
		var ok = false;
		
		if( typeof data.accion.tipo != 'undefined' ){
			hacer_js( data );
			ok =true;
		};
		return ok;
	};
	function hacer_js( data ){
		var referencia = '';
		if(typeof data.accion.referencia != 'undefined'  ){
			referencia = ', "'+data.accion.referencia+'" , "'+data.recipiente+'"';
		};
		eval( data.accion.funcion+'('+data.accion.attr+referencia+')' );
	};
	function do_proceso( data, recipiente, callback, atributos ){
		/*imprimir ajax en recipiente*/
		cargando();
		var recipiente	= $(recipiente);
		/*SET AJAX: SINO NO FUNCIONAN LAS DEL ADMIN*/
		data.ajax_gafa = true;
		ajax_GF = $.post('<?php plantilla()?>/procesos/do_action.php',data).done(function(d){
			var info = JSON.parse( d );
			if( !info || !info.ok ){
				alert( info.mensaje );
				return;
			};
			recipiente.html( info.data );
			
			if( callback ){
				callback( atributos );
			};
		}).always(function(){
			borrarCargando();
		});
	};
	function save_data( data, proceso, callback, callback_attr ){
		/*ENVIO DE INFO, HACER PROCESO O CALLBACK*/
		cargando();
		/*SET AJAX: SINO NO FUNCIONAN LAS DEL ADMIN*/
		data.ajax_gafa = true;
		ajax_GF = $.post( '<?php plantilla()?>/procesos/do_action.php', data ).done(function(d){
			var info = JSON.parse( d );
			if( !info || !info.ok ){
				alert( info.mensaje );
				return;
			}else{
				if( info.data ){
					$('body').append( info.data );
				};
				if( proceso ){
					do_proceso( proceso[0], proceso[1] );
				}else if( callback ){
					callback( callback_attr );
				};
			};
		}).always(function(){
			borrarCargando();
		});
	};
	function iniciar_Web(){
		configurar_Web();
		link_actual();
		iniciada = true;
	};
	function link_actual(){
		var url = document.location.href;
		$('[href="'+url+'"]').addClass('link_actual');
	};
	function configurar_Web(){
		
	};
	function config_contenido( element ){
		var alto = $window.height() - $('#menu_sup').outerHeight();
		
		if( element.length == 1 ){
			procesar( element )
		}else{
			$( element ).each(function(i, e) {
				procesar( $(e) );
			});
		};
		function procesar( este ){
			este.removeAttr('style');/*RESET*/
			este.css( 'min-height',alto );
			if( este.height() == alto ){
				este.removeAttr('style');/*RESET*/
				este.outerHeight( alto );
			};
		};
	};
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
		});
		return vars;
	};
	/**
	 * Checa si una dirección de email es válida.
	 * @return bool true si el email es válido.
	 */
	function isValidEmailAddress(emailAddress) {
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		return pattern.test(emailAddress);
	}
	function check_formularios( formulario ){
		var ok = true;
		var inputs = formulario.find('input:not(".no_obligatorio"),select:not(".no_obligatorio"),textarea:not(".no_obligatorio")');
		
		inputs.each(function(i, e) {
			if( $(e).val() == '' ){
				$(e).addClass('con_error');
				ok =false;
			}else{
				$(e).removeClass('con_error');
			};
		});
		if( !ok ){
			alert('Completa todos los campos del formulario marcados');
			return ok;
		};
		var numeros = formulario.find('[type="number"]');
		if( numeros.length ){
			/*SON NUMEROS?*/
			numeros.each(function(i,e){
				if( isNaN( $(e).val() ) ){
					$(e).addClass('con_error');
					ok =false;
				}else{
				$(e).removeClass('con_error');
				};
			});
			if( !ok ){
				alert('Los campos marcados en rojo deben de ser numéricos');
				return ok;
			};
		};
		/*MAILS------------------------------------*/
		var mails = formulario.find('[type="email"]');
		mails.each(function(i,e){
			if( !isValidEmailAddress($(e).val()) ){
				$(e).addClass('con_error');
				ok =false;
			}else{
				$(e).removeClass('con_error');
			};
		});
		if( !ok ){
			alert('Escribe un correo electrónico válido');
			return ok;
		};
		/*SIZE----------------------------*/
		var size = formulario.find('[size]');
		size.each(function(i,e){
			if( $(e).val().length != $(e).attr('size') ){
				$(e).addClass('con_error');
				ok =false;
			}else{
				$(e).removeClass('con_error');
			};
		});
		if( !ok ){
			alert('Los campos requeridos no tienen el tamaño necesario para continuar');
			return ok;
		};
		
		return ok;
	};
	
	/*PARALLAX OFFSET*/
	function parallax_W(elemento,altura,velocidad,padre,direccion,solo_valor){
		if(!elemento){
			alert('No has seleccionado ningun elemento para test_Offset');
		};
		if(!altura){
			var altura		= 0;
		};
		if(!velocidad){
			var velocidad	= 1;
		};
		if(!padre){
			var padre		= elemento.parent();
		};
		if(!direccion){
			var direccion		= 'top';
		};
		var topPadre		= padre.offset().top-jQuery(window).scrollTop();
		if (padre.offset().top == 1104) {
			/*console.log('P: '+padre.offset().top);*/
			console.log(jQuery(window).scrollTop());	
		};
		
		if(isNaN(altura)){
			switch(direccion){
				case 'left':
					var posNino			= padre.outerWidth()*(parseInt(altura)/100);
				break;
				default:
					var posNino			= padre.outerHeight()*(parseInt(altura)/100);
				break;
			};
			
		}else{
			var posNino			= altura;
		};
		var topEle			= (topPadre*velocidad)+posNino;
		
		if(solo_valor){
			return parseInt(topEle);
		};
		$(elemento).css(direccion,topEle);
	};
});


// ]]></script>