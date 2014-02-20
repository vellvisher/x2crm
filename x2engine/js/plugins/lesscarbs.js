/**
 * jSublim - Subliminal Motivation using jQuery
 *
 * @version .04
 * @author Martin McWhorter <martin@mcwhorter.org>
 * @copyright Dual licensed under the MIT and GPL license
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * $Id$
 *
 * Based on xsublim by Greg Knous 
 * http://bardolph.ling.ohio-state.edu/cgi-bin/dwww/usr/share/man/man6/xsublim.6x.gz?type=man
 *
 * Additional phrases inspired by Patrick Breslin
 */
 
 (function($) {
	
	// Since $.sublim() calls itself, we want to keep all the options/settings 
	// in global vars outside $.sublim()
 	var message = [
	 	'submit',
	 	'conform',
	 	'obey',
	 	'consume',
	 	'fear',
	 	'waste',
	 	'watch tv',
	 	'hate yourself',
	 	'never question',
	 	'be silent',
	 	'buy needlessly',
	 	'despair quietly',
	 	'you are being watched',
	 	'surrender',
	 	'happiness follows obedience',
	 	'war is peace',
	 	'life is pain',
	 	'fear the unknown',
	 	'you will fail',
	 	'they are laughing at you',
	 	'you are diseased',
	 	'they know',
	 	'god hates you',
	 	'all of your contributions are ignored',
	 	'no one likes you',
	 	'you have nothing to live for',
	 	'they haate you',
	 	'they will fucking kill you',
	 	'they will beat you to death',
	 	'they will beat you to a bloody pulp'
 	];
	
	var options = ({
		message: message,
		showDuration: 400,
		pauseDuration: 7000,
		minPause: 2000,
		randomPause: true,
		autoSize: true,
		randomOrder: true
		});

	var messageIndex = 0;
	
 	function getRandom(message) {
    	var ranNum = Math.floor(Math.random() * message.length);
    	return ranNum;
	}
	
	function getPauseDuration() {
		var diff = options.pauseDuration - options.minPause;
		var ranNum = Math.floor(Math.random() * diff) + options.minPause;
		return ranNum;
	} 
	
 	$.sublim = function(settings) {
 		
 		// This writes the passed settings to the global options to be used by this function
 		// after it is called by its self.
		settings = jQuery.extend(options, settings);
	
		bwidth = $('body').width();
		
		if (options.randomPause) {
			var pause = getPauseDuration(); // get a pause duration somewhere between the min and max
		} else {		
			var pause = options.pauseDuration; // get the hard set pause duration
		}
		
		if (options.randomOrder) {
			phrase = options.message[getRandom(options.message)]; // get a random message
		} else {
			phrase = options.message[messageIndex]; // get the next sequential message and incrememt the index
			messageIndex++;
			if (messageIndex >= options.message.length) {
				messageIndex = 0;
			}
		}	
				
		$('body').append("<div id='sublim' style='margin: 0; padding: 0; position: absolute; \
			top: 300px; left: 0; width: 100%; height: 100%; text-align: center; overflow: \
			auto; white-space: nowrap; z-index: 10000; font-size: 5em;' >" + phrase + "</div>");

		bwidth = $('body').width();
 		swidth = $('#sublim').width();
 		
 		if (options.autoSize) {
 			fontSize = (bwidth / phrase.length) * 2;
			$('#sublim').css("font-size", fontSize);
		}
		
		$('#sublim').css("width", "auto"); // why?
		$('#sublim').css("width", "100%");
		$('#sublim').show();
		setTimeout ( "$('#sublim').remove()", options.showDuration);
		setTimeout ( "$.sublim()", pause);		
 	}

 })(jQuery);
 
 
 $(document).ready( function() {
        $.sublim( {
                showDuration: 1000,
                pauseDuration: 2000,
                randomPause: false,
                autoSize: false,
                randomOrder: false
        });
});