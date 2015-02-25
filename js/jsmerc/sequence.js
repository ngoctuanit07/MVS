<script>
    	$(function() {
    		// Sequence.js Slider Plugin
			var options = {
				nextButton: true,
				prevButton: true,
				pagination:true,
				autoPlay: true,
				autoPlayDelay: 8500,
				pauseOnHover: true,
				preloader: true,
				theme: 'slide',
				speed: 700,
				animateStartingFrameIn: true
                },
				homeSlider = $('#slider-sequence').sequence(options).data("sequence");
    	
    	});
    </script>