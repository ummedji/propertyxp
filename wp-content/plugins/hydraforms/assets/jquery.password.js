(function ($) {

    $.fn.passwordValidation = function(options) {
        options = $.extend({}, $.fn.passwordValidation.defaults, options);


        $(this).on('keyup', function(e){
            options.setScore(getScore($(this).val()))
        });

        var getScore = function(value){
            var points = 0;
            if(value !== '' && value.length > 0){
                var letters = new Object();

                for (var i=0; i<value.length; i++) {
                    points += 5.0;
                }

                var variations = {
                    digits: /\d/.test(value),
                    lower: /[a-z]/.test(value),
                    upper: /[A-Z]/.test(value),
                    nonWords: /\W/.test(value)
                };

                var variationCount = 0;
                for (var check in variations) {
                    variationCount += (variations[check] == true) ? 1 : 0;
                }
                points += (variationCount - 1) * 10;
            }

            return parseInt(points);
        }

        options.setScore(getScore($(this).val()));
    };

    $.fn.passwordValidation.defaults = {
        weakLabel: 'Weak',
        mediumLabel: 'Medium',
        strongLabel: 'Strong',
        setScore: function(score){
            var $progress = $('.progress');
            var $bar = $progress.find('.progress-bar');
            var message = this.weakLabel;
            var cssClass = 'progress-bar-danger';

            $bar.removeClass('progress-bar-danger progress-bar-warning progress-bar-success');

            if(score > 100){
                score = 100;
            }
            if(score >= 65){
                cssClass = 'progress-bar-success';
                message = this.strongLabel;
            } else if(score >= 40){
                cssClass = 'progress-bar-warning';
                message = this.mediumLabel;
            } else if(score == 0){
                cssClass = 'progress-bar-danger';
                message = '';
            }

            $bar.addClass(cssClass);
            $bar.css({'width': score + '%'}).html(message);
            $bar.show();
        }
    };
})(jQuery);