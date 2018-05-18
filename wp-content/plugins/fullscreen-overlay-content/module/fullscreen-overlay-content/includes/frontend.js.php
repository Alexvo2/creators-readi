(function($) {
	
	$(function(){
		if( $('body').find('.fsoc-<?php echo $module->node;?>-content') )
		{
			$( '.fsoc-<?php echo $module->node;?>-content' ).appendTo( $( "body" ) );
		}
	});
	
	<?php if( $module->settings->anim_style == 'contentpush' ) : ?>
		//container = document.querySelector( 'div.fl-page' ),
		var triggerCPBttn = document.getElementById( 'trigger-overlay-<?php echo $id; ?>' ),
			overlayCP = document.querySelector( 'div.fsoc-<?php echo $id; ?>-content' ),
			closeCPBttn = overlayCP.querySelector( 'div.fsoc-<?php echo $id; ?>-close-btn' );
			transEndEventNames = {
				'WebkitTransition': 'webkitTransitionEnd',
				'MozTransition': 'transitionend',
				'OTransition': 'oTransitionEnd',
				'msTransition': 'MSTransitionEnd',
				'transition': 'transitionend'
			},
			transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
			support = { transitions : Modernizr.csstransitions };

		function toggleContentPushOverlay() {
			if( classie.has( overlayCP, 'open' ) ) {
				classie.remove( overlayCP, 'open' );
				//classie.remove( container, 'overlay-open' );
				classie.add( overlayCP, 'close' );
				var onEndTransitionFn = function( ev ) {
					if( support.transitions ) {
						if( ev.propertyName !== 'visibility' ) return;
						this.removeEventListener( transEndEventName, onEndTransitionFn );
					}
					classie.remove( overlayCP, 'close' );
				};
				if( support.transitions ) {
					overlayCP.addEventListener( transEndEventName, onEndTransitionFn );
				}
				else {
					onEndTransitionFn();
				}
			}
			else if( !classie.has( overlayCP, 'close' ) ) {
				classie.add( overlayCP, 'open' );
				//classie.add( container, 'overlay-open' );
			}
		}
	<?php elseif( $module->settings->anim_style == 'genie' ) :?>
		var triggerBttn = document.getElementById( 'trigger-overlay-<?php echo $id; ?>' ),
			overlay = document.querySelector( 'div.fsoc-<?php echo $id; ?>-content' ),
			closeBttn = overlay.querySelector( 'div.fsoc-<?php echo $id; ?>-close-btn' );
			transEndEventNames = {
				'WebkitTransition': 'webkitTransitionEnd',
				'MozTransition': 'transitionend',
				'OTransition': 'oTransitionEnd',
				'msTransition': 'MSTransitionEnd',
				'transition': 'transitionend'
			},
			transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
			support = { transitions : Modernizr.csstransitions };
			s = Snap( overlay.querySelector( 'svg' ) ), 
			path = s.select( 'path' ),
			steps = overlay.getAttribute( 'data-steps' ).split(';'),
			stepsTotal = steps.length;

		function toggleOverlay() {
			if( classie.has( overlay, 'open' ) ) {
				var pos = stepsTotal-1;
				classie.remove( overlay, 'open' );
				classie.add( overlay, 'close' );
				
				var onEndTransitionFn = function( ev ) {
						classie.remove( overlay, 'close' );
					},
					nextStep = function( pos ) {
						pos--;
						if( pos < 0 ) return;
						path.animate( { 'path' : steps[pos] }, 60, mina.linear, function() { 
							if( pos === 0 ) {
								onEndTransitionFn();
							}
							nextStep(pos);
						} );
					};

				nextStep(pos);
			}
			else if( !classie.has( overlay, 'close' ) ) {
				var pos = 0;
				classie.add( overlay, 'open' );
				
				var nextStep = function( pos ) {
					pos++;
					if( pos > stepsTotal - 1 ) return;
					path.animate( { 'path' : steps[pos] }, 60, mina.linear, function() { nextStep(pos); } );
				};

				nextStep(pos);
			}
		}
	<?php else: ?>
	var triggerBttn = document.getElementById( 'trigger-overlay-<?php echo $id; ?>' ),
		overlay = document.querySelector( 'div.fsoc-<?php echo $id; ?>-content' ),
		closeBttn = overlay.querySelector( 'div.fsoc-<?php echo $id; ?>-close-btn' );
		transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		support = { transitions : Modernizr.csstransitions };

	function toggleOverlay() {
		if( classie.has( overlay, 'open' ) ) {
			classie.remove( overlay, 'open' );
			classie.add( overlay, 'close' );
			var onEndTransitionFn = function( ev ) {
				if( support.transitions ) {
					if( ev.propertyName !== 'visibility' ) return;
					this.removeEventListener( transEndEventName, onEndTransitionFn );
				}
				classie.remove( overlay, 'close' );
			};
			if( support.transitions ) {
				overlay.addEventListener( transEndEventName, onEndTransitionFn );
			}
			else {
				onEndTransitionFn();
			}
		}
		else if( !classie.has( overlay, 'close' ) ) {
			classie.add( overlay, 'open' );
		}
	}
	<?php endif; ?>

	<?php if( $module->settings->anim_style == 'contentpush' ) :?>
		triggerCPBttn.addEventListener( 'click', toggleContentPushOverlay );
		closeCPBttn.addEventListener( 'click', toggleContentPushOverlay );
	<?php else: ?>
		triggerBttn.addEventListener( 'click', toggleOverlay );
		closeBttn.addEventListener( 'click', toggleOverlay );
	<?php endif; ?>
})(jQuery);