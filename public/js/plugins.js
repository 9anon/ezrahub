/*
 * SimpleModal 1.4.4 - jQuery Plugin
 * http://simplemodal.com/
 * Copyright (c) 2013 Eric Martin
 * Licensed under MIT and GPL
 * Date: Sun, Jan 20 2013 15:58:56 -0800
 */
(function(b){"function"===typeof define&&define.amd?define(["jquery"],b):b(jQuery)})(function(b){var j=[],n=b(document),k=navigator.userAgent.toLowerCase(),l=b(window),g=[],o=null,p=/msie/.test(k)&&!/opera/.test(k),q=/opera/.test(k),m,r;m=p&&/msie 6./.test(k)&&"object"!==typeof window.XMLHttpRequest;r=p&&/msie 7.0/.test(k);b.modal=function(a,h){return b.modal.impl.init(a,h)};b.modal.close=function(){b.modal.impl.close()};b.modal.focus=function(a){b.modal.impl.focus(a)};b.modal.setContainerDimensions=
function(){b.modal.impl.setContainerDimensions()};b.modal.setPosition=function(){b.modal.impl.setPosition()};b.modal.update=function(a,h){b.modal.impl.update(a,h)};b.fn.modal=function(a){return b.modal.impl.init(this,a)};b.modal.defaults={appendTo:"body",focus:!0,opacity:90,overlayId:"simplemodal-overlay",overlayCss:{},containerId:"simplemodal-container",containerCss:{},dataId:"simplemodal-data",dataCss:{},minHeight:null,minWidth:null,maxHeight:null,maxWidth:null,autoResize:!1,autoPosition:!0,zIndex:1E3,
close:!0,closeHTML:'<a class="modalCloseImg" title="Close"></a>',closeClass:"simplemodal-close",escClose:!0,overlayClose:!1,fixed:!0,position:null,persist:!1,modal:!0,onOpen:null,onShow:null,onClose:null};b.modal.impl={d:{},init:function(a,h){if(this.d.data)return!1;o=p&&!b.support.boxModel;this.o=b.extend({},b.modal.defaults,h);this.zIndex=this.o.zIndex;this.occb=!1;if("object"===typeof a){if(a=a instanceof b?a:b(a),this.d.placeholder=!1,0<a.parent().parent().size()&&(a.before(b("<span></span>").attr("id",
"simplemodal-placeholder").css({display:"none"})),this.d.placeholder=!0,this.display=a.css("display"),!this.o.persist))this.d.orig=a.clone(!0)}else if("string"===typeof a||"number"===typeof a)a=b("<div></div>").html(a);else return alert("SimpleModal Error: Unsupported data type: "+typeof a),this;this.create(a);this.open();b.isFunction(this.o.onShow)&&this.o.onShow.apply(this,[this.d]);return this},create:function(a){this.getDimensions();if(this.o.modal&&m)this.d.iframe=b('<iframe src="javascript:false;"></iframe>').css(b.extend(this.o.iframeCss,
{display:"none",opacity:0,position:"fixed",height:g[0],width:g[1],zIndex:this.o.zIndex,top:0,left:0})).appendTo(this.o.appendTo);this.d.overlay=b("<div></div>").attr("id",this.o.overlayId).addClass("simplemodal-overlay").css(b.extend(this.o.overlayCss,{display:"none",opacity:this.o.opacity/100,height:this.o.modal?j[0]:0,width:this.o.modal?j[1]:0,position:"fixed",left:0,top:0,zIndex:this.o.zIndex+1})).appendTo(this.o.appendTo);this.d.container=b("<div></div>").attr("id",this.o.containerId).addClass("simplemodal-container").css(b.extend({position:this.o.fixed?
"fixed":"absolute"},this.o.containerCss,{display:"none",zIndex:this.o.zIndex+2})).append(this.o.close&&this.o.closeHTML?b(this.o.closeHTML).addClass(this.o.closeClass):"").appendTo(this.o.appendTo);this.d.wrap=b("<div></div>").attr("tabIndex",-1).addClass("simplemodal-wrap").css({height:"100%",outline:0,width:"100%"}).appendTo(this.d.container);this.d.data=a.attr("id",a.attr("id")||this.o.dataId).addClass("simplemodal-data").css(b.extend(this.o.dataCss,{display:"none"})).appendTo("body");this.setContainerDimensions();
this.d.data.appendTo(this.d.wrap);(m||o)&&this.fixIE()},bindEvents:function(){var a=this;b("."+a.o.closeClass).bind("click.simplemodal",function(b){b.preventDefault();a.close()});a.o.modal&&a.o.close&&a.o.overlayClose&&a.d.overlay.bind("click.simplemodal",function(b){b.preventDefault();a.close()});n.bind("keydown.simplemodal",function(b){a.o.modal&&9===b.keyCode?a.watchTab(b):a.o.close&&a.o.escClose&&27===b.keyCode&&(b.preventDefault(),a.close())});l.bind("resize.simplemodal orientationchange.simplemodal",
function(){a.getDimensions();a.o.autoResize?a.setContainerDimensions():a.o.autoPosition&&a.setPosition();m||o?a.fixIE():a.o.modal&&(a.d.iframe&&a.d.iframe.css({height:g[0],width:g[1]}),a.d.overlay.css({height:j[0],width:j[1]}))})},unbindEvents:function(){b("."+this.o.closeClass).unbind("click.simplemodal");n.unbind("keydown.simplemodal");l.unbind(".simplemodal");this.d.overlay.unbind("click.simplemodal")},fixIE:function(){var a=this.o.position;b.each([this.d.iframe||null,!this.o.modal?null:this.d.overlay,
"fixed"===this.d.container.css("position")?this.d.container:null],function(b,e){if(e){var f=e[0].style;f.position="absolute";if(2>b)f.removeExpression("height"),f.removeExpression("width"),f.setExpression("height",'document.body.scrollHeight > document.body.clientHeight ? document.body.scrollHeight : document.body.clientHeight + "px"'),f.setExpression("width",'document.body.scrollWidth > document.body.clientWidth ? document.body.scrollWidth : document.body.clientWidth + "px"');else{var c,d;a&&a.constructor===
Array?(c=a[0]?"number"===typeof a[0]?a[0].toString():a[0].replace(/px/,""):e.css("top").replace(/px/,""),c=-1===c.indexOf("%")?c+' + (t = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"':parseInt(c.replace(/%/,""))+' * ((document.documentElement.clientHeight || document.body.clientHeight) / 100) + (t = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"',a[1]&&(d="number"===typeof a[1]?
a[1].toString():a[1].replace(/px/,""),d=-1===d.indexOf("%")?d+' + (t = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft) + "px"':parseInt(d.replace(/%/,""))+' * ((document.documentElement.clientWidth || document.body.clientWidth) / 100) + (t = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft) + "px"')):(c='(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (t = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"',
d='(document.documentElement.clientWidth || document.body.clientWidth) / 2 - (this.offsetWidth / 2) + (t = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft) + "px"');f.removeExpression("top");f.removeExpression("left");f.setExpression("top",c);f.setExpression("left",d)}}})},focus:function(a){var h=this,a=a&&-1!==b.inArray(a,["first","last"])?a:"first",e=b(":input:enabled:visible:"+a,h.d.wrap);setTimeout(function(){0<e.length?e.focus():h.d.wrap.focus()},
10)},getDimensions:function(){var a="undefined"===typeof window.innerHeight?l.height():window.innerHeight;j=[n.height(),n.width()];g=[a,l.width()]},getVal:function(a,b){return a?"number"===typeof a?a:"auto"===a?0:0<a.indexOf("%")?parseInt(a.replace(/%/,""))/100*("h"===b?g[0]:g[1]):parseInt(a.replace(/px/,"")):null},update:function(a,b){if(!this.d.data)return!1;this.d.origHeight=this.getVal(a,"h");this.d.origWidth=this.getVal(b,"w");this.d.data.hide();a&&this.d.container.css("height",a);b&&this.d.container.css("width",
b);this.setContainerDimensions();this.d.data.show();this.o.focus&&this.focus();this.unbindEvents();this.bindEvents()},setContainerDimensions:function(){var a=m||r,b=this.d.origHeight?this.d.origHeight:q?this.d.container.height():this.getVal(a?this.d.container[0].currentStyle.height:this.d.container.css("height"),"h"),a=this.d.origWidth?this.d.origWidth:q?this.d.container.width():this.getVal(a?this.d.container[0].currentStyle.width:this.d.container.css("width"),"w"),e=this.d.data.outerHeight(!0),f=
this.d.data.outerWidth(!0);this.d.origHeight=this.d.origHeight||b;this.d.origWidth=this.d.origWidth||a;var c=this.o.maxHeight?this.getVal(this.o.maxHeight,"h"):null,d=this.o.maxWidth?this.getVal(this.o.maxWidth,"w"):null,c=c&&c<g[0]?c:g[0],d=d&&d<g[1]?d:g[1],i=this.o.minHeight?this.getVal(this.o.minHeight,"h"):"auto",b=b?this.o.autoResize&&b>c?c:b<i?i:b:e?e>c?c:this.o.minHeight&&"auto"!==i&&e<i?i:e:i,c=this.o.minWidth?this.getVal(this.o.minWidth,"w"):"auto",a=a?this.o.autoResize&&a>d?d:a<c?c:a:f?
f>d?d:this.o.minWidth&&"auto"!==c&&f<c?c:f:c;this.d.container.css({height:b,width:a});this.d.wrap.css({overflow:e>b||f>a?"auto":"visible"});this.o.autoPosition&&this.setPosition()},setPosition:function(){var a,b;a=g[0]/2-this.d.container.outerHeight(!0)/2;b=g[1]/2-this.d.container.outerWidth(!0)/2;var e="fixed"!==this.d.container.css("position")?l.scrollTop():0;this.o.position&&"[object Array]"===Object.prototype.toString.call(this.o.position)?(a=e+(this.o.position[0]||a),b=this.o.position[1]||b):
a=e+a;this.d.container.css({left:b,top:a})},watchTab:function(a){if(0<b(a.target).parents(".simplemodal-container").length){if(this.inputs=b(":input:enabled:visible:first, :input:enabled:visible:last",this.d.data[0]),!a.shiftKey&&a.target===this.inputs[this.inputs.length-1]||a.shiftKey&&a.target===this.inputs[0]||0===this.inputs.length)a.preventDefault(),this.focus(a.shiftKey?"last":"first")}else a.preventDefault(),this.focus()},open:function(){this.d.iframe&&this.d.iframe.show();b.isFunction(this.o.onOpen)?
this.o.onOpen.apply(this,[this.d]):(this.d.overlay.show(),this.d.container.show(),this.d.data.show());this.o.focus&&this.focus();this.bindEvents()},close:function(){if(!this.d.data)return!1;this.unbindEvents();if(b.isFunction(this.o.onClose)&&!this.occb)this.occb=!0,this.o.onClose.apply(this,[this.d]);else{if(this.d.placeholder){var a=b("#simplemodal-placeholder");this.o.persist?a.replaceWith(this.d.data.removeClass("simplemodal-data").css("display",this.display)):(this.d.data.hide().remove(),a.replaceWith(this.d.orig))}else this.d.data.hide().remove();
this.d.container.hide().remove();this.d.overlay.hide();this.d.iframe&&this.d.iframe.hide().remove();this.d.overlay.remove();this.d={}}}}});

/**
 * Textarea
 * Copyright 2013 Will Najar
 *
 * A modular textarea drop-in with some nifty addons that you can use to enhance functionality in any project where text is input via a textarea element.
 * Designed for use on the website Ezra Hub (http://ezrahub.com/).
 *
 * @url https://github.com/wnajar/textarea
 */

/**
 * Colors to be displayed in the progress bar, from first displayed to last
 * @type {Object} Config
 */
var colors = {
    'first': '#ff7070',
    'second': '#e8ad72',
    'third': '#7272e8',
    'fourth': '#8888ec',
    'fifth': '#3ff53f',
    'sixth' : '#3ff53f'
};

/**
 * Text to display with each rating
 * @type {Object} Config
 */
var content = {
    'first': 'well this is awkward...',
    'second': 'you\'re getting there...',
    'third': 'p-pretty good!',
    'fourth': 'not bad at all!',
    'fifth': 'yeah buddy!',
    'filtered': 'please... stay safe.'
};

/**
 * Cutoffs for each level of the progress bar, from lowest to highest
 * @type {Object} Config
 */
var cutoff = {
    'first': '15',
    'second': '45',
    'third': '75',
    'fourth': '100',
};

//intelligence levels to report
var intelligences = {
    'one': 'You in ILR bro?',
    'two': 'Comm or Psych.',
    'three': 'Average humanities.',
    'four': 'Hard sciences.',
    'five': 'Average engineer.',
    'six': 'ECE or AEP.'
};

//intelligence levels to report
var intelcutoff = {
    'first': 4,
    'second': 5,
    'third': 6,
    'fourth': 8,
    'fifth': 10,
};

var bbcode = {
    bold: function(id) {
        wrapText($("textarea.enhanced"), "[b]", "[/b]", "", "bolded text");
    },
    italic: function(id) {
        wrapText($("textarea.enhanced"), "[i]", "[/i]", "", "italicized text");
    },
    heading: function(id) {
        wrapText($("textarea.enhanced"), "[h]", "[/h]", "", "heading");
    },
    link: function(id) {
        wrapText($("textarea.enhanced"), "[url]", "[/url]", "", "link url");
    },
    image: function(id) {
        wrapText($("textarea.enhanced"), "[img]", "[/img]", "", "image url");
    },
    youtube: function(id) {
        wrapText($("textarea.enhanced"), "[youtube]", "[/youtube]", "", "unique video id");
    },
    quote: function(id) {
        wrapText($("textarea.enhanced"), "[quote]", "[/quote]", "", "quoted text");
    },
    list: function(id) {
        wrapText($("textarea.enhanced"), "[list]", "[/list]", "", "[*] item 1 [*] item 2 etc.");
    },
    strikethrough: function(id) {
        wrapText($("textarea.enhanced"), "[s]", "[/s]", "", "spoiler text");
    }
};

//on document ready
$(document).ready(function () {
    // initialize the rating
    $('span.rating').html('start typing...');
    //initialize arrays and objects
    var wordcount = {};

    //function to update progress bar and ratings as user types
    $(document).on('keyup', 'textarea.enhanced', function () {

        //analyze the text in the textarea and send it to textstatistics
        var texttoanalyze = $('textarea.enhanced').val();
        var score = new textstatistics(texttoanalyze);
        delay(function() {
            if (texttoanalyze != '') {
                report_score(score);
            }
        }, 250);

        //find words in the textarea
        var matches = this.value.match(/\b/g);
        wordcount[this.id] = matches ? matches.length / 2 : 0;

        //work out what rating and paramaters to pass to update_rating()
        var finalcount = 0;
        $.each(wordcount, function (k, v) {
            finalcount += v;
            if (finalcount >= cutoff.fourth) {
                update_rating('four', content.fifth, colors.fifth);
            } else if (finalcount >= cutoff.third) {
                update_rating('three', content.fourth, colors.fourth);
            } else if (finalcount >= cutoff.second) {
                update_rating('two', content.third, colors.third);
            } else if (finalcount >= cutoff.first) {
                update_rating('one', content.second, colors.second);
            } else if (finalcount != 0) {
                update_rating('zero', content.first, colors.first);
            } else {
                update_rating('zero', content.first, colors.first);
            }
        });
        //update the count of words
        if (finalcount === 1) {
            $('span.noun').html('word');
        } else if ($('span.noun').html() != 'words' /*don't keep resetting if already set*/) {
            $('span.noun').html('words');
        }

        //update the word count
        $('#final-count').html(finalcount);
    });

    //click handlers for formatting buttons
    $(document).on('click', 'span.format-icon', function () {
        //sort out which action we are doing
        var action = $(this).data("action");
        switch (action) {
            case "bold":
                bbcode.bold();
                break;
            case "italic":
                bbcode.italic();
                break;
            case 'heading':
                bbcode.heading();
                break;
            case 'link':
                bbcode.link();
                break;
            case 'image':
                bbcode.image();
                break;
            case 'youtube':
                bbcode.youtube();
                break;
            case 'quote':
                bbcode.quote();
                break;
            case 'list':
                bbcode.list();
                break;
            case 'strikethrough':
                bbcode.strikethrough();
                break;
        }
    });
});

//function to report the intelligence score of the text
function report_score(statisticsobject) {
    //calculate the SMOG index for the user's post
    //http://en.wikipedia.org/wiki/SMOG
    var smog = statisticsobject.smogIndex();
    //initialize variables to be set
    var intelligence = 'init';
    var color = 'init';
    //sort out how intelligent the user is
    if (smog >= intelcutoff.fifth) {
        intelligence = intelligences.six;
        color = colors.sixth;
    } else if ( smog >= intelcutoff.fourth) {
        intelligence = intelligences.five;
        color = colors.fifth;
    } else if (smog >= intelcutoff.third) {
        intelligence =  intelligences.four;
        color = colors.fourth;
    } else if (smog >= intelcutoff.second) {
        intelligence = intelligences.three;
        color = colors.third;
    } else if (smog >= intelcutoff.first) {
        intelligence = intelligences.two;
        color = colors.second;
    } else {
        intelligence = intelligences.one;
        color = colors.first;
    }
    //apply changes to the form is there was an intelligence change
    if ($('span.stats-rating').html() != intelligence) {
        $('span.stats-rating').html(intelligence).css('color', color);
        $('span#stats').show();
    }
}

// function to update the progress bar and rating
function update_rating(spanclass, content, color) {
    if ($('span.rating').html() != '<span class="' + spanclass + '">' + content + '</span>') {
        $('span.rating').html('<span class="' + spanclass + '">' + content + '</span>').css('color', color);
    }
}

//prototype function to find unique values in an array
Array.prototype.getUnique = function () {
    var u = {}, a = [];
    for (var i = 0, l = this.length; i < l; ++i) {
        if (u.hasOwnProperty(this[i])) {
            continue;
        }
        a.push(this[i]);
        u[this[i]] = 1;
    }
    return a;
}

//function to delay the real-time results a specified amount
var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

// TextStatistics.js - https://github.com/DaveChild/Text-Statistics
(function(glob) {

    function cleanText(text) {
        // all these tags should be preceeded by a full stop.
        var fullStopTags = ['li', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'dd'];

        fullStopTags.forEach(function(tag) {
            text = text.replace("</" + tag + ">",".");
        })

        text = text
            .replace(/<[^>]+>/g, "")                // Strip tags
            .replace(/[,:;()\-]/, " ")              // Replace commans, hyphens etc (count them as spaces)
            .replace(/[\.!?]/, ".")                 // Unify terminators
            .replace(/^\s+/,"")                     // Strip leading whitespace
            .replace(/[ ]*(\n|\r\n|\r)[ ]*/," ")    // Replace new lines with spaces
            .replace(/([\.])[\. ]+/,".")            // Check for duplicated terminators
            .replace(/[ ]*([\.])/,". ")             // Pad sentence terminators
            .replace(/\s+/," ")                     // Remove multiple spaces
            .replace(/\s+$/,"");                    // Strip trailing whitespace

        text += "."; // Add final terminator, just in case it's missing.

        return text;
    }

    var TextStatistics = function TextStatistics(text) {
        this.text = text ? cleanText(text) : this.text;
    };

    TextStatistics.prototype.fleschKincaidReadingEase = function(text) {
        text = text ? cleanText(text) : this.text;
        return Math.round((206.835 - (1.015 * this.averageWordsPerSentence(text)) - (84.6 * this.averageSyllablesPerWord(text)))*10)/10;
    };

    TextStatistics.prototype.fleschKincaidGradeLevel = function(text) {
        text = text ? cleanText(text) : this.text;
        return Math.round(((0.39 * this.averageWordsPerSentence(text)) + (11.8 * this.averageSyllablesPerWord(text)) - 15.59)*10)/10;
    };

    TextStatistics.prototype.gunningFogScore = function(text) {
        text = text ? cleanText(text) : this.text;
        return Math.round(((this.averageWordsPerSentence(text) + this.percentageWordsWithThreeSyllables(text, false)) * 0.4)*10)/10;
    };

    TextStatistics.prototype.colemanLiauIndex = function(text) {
        text = text ? cleanText(text) : this.text;
        return Math.round(((5.89 * (this.letterCount(text) / this.wordCount(text))) - (0.3 * (this.sentenceCount(text) / this.wordCount(text))) - 15.8 ) *10)/10;
    };

    TextStatistics.prototype.smogIndex = function(text) {
        text = text ? cleanText(text) : this.text;
        return Math.round(1.043 * Math.sqrt((this.wordsWithThreeSyllables(text) * (30 / this.sentenceCount(text))) + 3.1291)*10)/10;
    };

    TextStatistics.prototype.automatedReadabilityIndex = function(text) {
        text = text ? cleanText(text) : this.text;
        return Math.round(((4.71 * (this.letterCount(text) / this.wordCount(text))) + (0.5 * (this.wordCount(text) / this.sentenceCount(text))) - 21.43)*10)/10;
    };

    TextStatistics.prototype.textLength = function(text) {
        text = text ? cleanText(text) : this.text;
        return text.length;
    };

    TextStatistics.prototype.letterCount = function(text) {
        text = text ? cleanText(text) : this.text;
        text = text.replace(/[^a-z]+/ig,"");
        return text.length;
    };

    TextStatistics.prototype.sentenceCount = function(text) {
        text = text ? cleanText(text) : this.text;

        // Will be tripped up by "Mr." or "U.K.". Not a major concern at this point.
        return text.replace(/[^\.!?]/g, '').length || 1;
    };

    TextStatistics.prototype.wordCount = function(text) {
        text = text ? cleanText(text) : this.text;
        return text.split(/[^a-z0-9]+/i).length || 1;
    };

    TextStatistics.prototype.averageWordsPerSentence = function(text) {
        text = text ? cleanText(text) : this.text;
        return this.wordCount(text) / this.sentenceCount(text);
    };

    TextStatistics.prototype.averageSyllablesPerWord = function(text) {
        text = text ? cleanText(text) : this.text;
        var syllableCount = 0, wordCount = this.wordCount(text), self = this;

        text.split(/\s+/).forEach(function(word) {
            syllableCount += self.syllableCount(word);
        });

        // Prevent NaN...
        return (syllableCount||1) / (wordCount||1);
    };

    TextStatistics.prototype.wordsWithThreeSyllables = function(text, countProperNouns) {
        text = text ? cleanText(text) : this.text;
        var longWordCount = 0, self = this;

        countProperNouns = countProperNouns === false ? false : true;

        text.split(/\s+/).forEach(function(word) {

            // We don't count proper nouns or capitalised words if the countProperNouns attribute is set.
            // Defaults to true.
            if (!word.match(/^[A-Z]/) || countProperNouns) {
                if (self.syllableCount(word) > 2) longWordCount ++;
            }
        });

        return longWordCount;
    };

    TextStatistics.prototype.percentageWordsWithThreeSyllables = function(text, countProperNouns) {
        text = text ? cleanText(text) : this.text;

        return (this.wordsWithThreeSyllables(text,countProperNouns) / this.wordCount(text)) * 100;
    };

    TextStatistics.prototype.syllableCount = function(word) {
        var syllableCount = 0,
            prefixSuffixCount = 0,
            wordPartCount = 0;

        // Prepare word - make lower case and remove non-word characters
        word = word.toLowerCase().replace(/[^a-z]/g,"");

        // Specific common exceptions that don't follow the rule set below are handled individually
        // Array of problem words (with word as key, syllable count as value)
        var problemWords = {
            "simile":       3,
            "forever":      3,
            "shoreline":    2
        };

        // Return if we've hit one of those...
        if (problemWords[word]) return problemWords[word];

        // These syllables would be counted as two but should be one
        var subSyllables = [
            /cial/,
            /tia/,
            /cius/,
            /cious/,
            /giu/,
            /ion/,
            /iou/,
            /sia$/,
            /[^aeiuoyt]{2,}ed$/,
            /.ely$/,
            /[cg]h?e[rsd]?$/,
            /rved?$/,
            /[aeiouy][dt]es?$/,
            /[aeiouy][^aeiouydt]e[rsd]?$/,
            /^[dr]e[aeiou][^aeiou]+$/, // Sorts out deal, deign etc
            /[aeiouy]rse$/ // Purse, hearse
        ];

        // These syllables would be counted as one but should be two
        var addSyllables = [
            /ia/,
            /riet/,
            /dien/,
            /iu/,
            /io/,
            /ii/,
            /[aeiouym]bl$/,
            /[aeiou]{3}/,
            /^mc/,
            /ism$/,
            /([^aeiouy])\1l$/,
            /[^l]lien/,
            /^coa[dglx]./,
            /[^gq]ua[^auieo]/,
            /dnt$/,
            /uity$/,
            /ie(r|st)$/
        ];

        // Single syllable prefixes and suffixes
        var prefixSuffix = [
            /^un/,
            /^fore/,
            /ly$/,
            /less$/,
            /ful$/,
            /ers?$/,
            /ings?$/
        ];

        // Remove prefixes and suffixes and count how many were taken
        prefixSuffix.forEach(function(regex) {
            if (word.match(regex)) {
                word = word.replace(regex,"");
                prefixSuffixCount ++;
            }
        });

        wordPartCount = word
            .split(/[^aeiouy]+/ig)
            .filter(function(wordPart) {
                return !!wordPart.replace(/\s+/ig,"").length
            })
            .length;

        // Get preliminary syllable count...
        syllableCount = wordPartCount + prefixSuffixCount;

        // Some syllables do not follow normal rules - check for them
        subSyllables.forEach(function(syllable) {
            if (word.match(syllable)) syllableCount --;
        });

        addSyllables.forEach(function(syllable) {
            if (word.match(syllable)) syllableCount ++;
        });

        return syllableCount || 1;
    };

    function textStatistics(text) {
        return new TextStatistics(text);
    }

    (typeof module != "undefined" && module.exports) ? (module.exports = textStatistics) : (typeof define != "undefined" ? (define("textstatistics", [], function() { return textStatistics; })) : (glob.textstatistics = textStatistics));
})(this);

//rangytext
$.fn.selectRange=function(a,b){return this.each(function(){if(this.setSelectionRange)this.focus(),this.setSelectionRange(a,b);else if(this.createTextRange){var c=this.createTextRange();c.collapse(!0);c.moveEnd("character",b);c.moveStart("character",a);c.select()}})};
$.fn.getSelection=function(){var a=this.jquery?this[0]:this;return("selectionStart"in a&&function(){var b=a.selectionEnd-a.selectionStart;return{start:a.selectionStart,end:a.selectionEnd,length:b,text:a.value.substr(a.selectionStart,b)}}||document.selection&&function(){a.focus();var b=document.selection.createRange();if(null===b)return{start:0,end:a.value.length,length:0};var c=a.createTextRange(),d=c.duplicate();c.moveToBookmark(b.getBookmark());d.setEndPoint("EndToStart",c);return{start:d.text.length,
end:d.text.length+b.text.length,length:b.text.length,text:b.text}}||function(){return null})()};$.getSelection=function(){if(window.getSelection)return window.getSelection();if(document.getSelection)return document.getSelection();if(document.selection)return document.selection.createRange().text};(function(a){a.fn.disable=function(){this.attr("disabled",!0).addClass("disabled")};a.fn.enable=function(){this.attr("disabled",!1).removeClass("disabled")}})(jQuery);
jQuery.unparam=function(a){var b={};a=a.split("&");var c,d,e;d=0;for(e=a.length;d<e;d++)c=a[d].split("=",2),b[decodeURIComponent(c[0])]=2==c.length?decodeURIComponent(c[1].replace(/\+/g," ")):!0;return b};

 // Add text to the reply area at the very end, and move the cursor to the very end.
function insertText(textarea, text) {
    textarea = $(textarea);
    textarea.focus();
    textarea.val(textarea.val() + text);
    textarea.focus();
    // Trigger the textarea's keyup to emulate typing.
    textarea.trigger("keyup");
}

// Add text to the reply area, with the options of wrapping it around a selection and selecting a part of it when it's inserted.
function wrapText(textarea, tagStart, tagEnd, selectArgument, defaultArgumentValue) {
    textarea = $(textarea);
    // Save the scroll position of the textarea.
    var scrollTop = textarea.scrollTop();
    // Work out what text is currently selected.
    var selectionInfo = textarea.getSelection();
    if (textarea.val().substring(selectionInfo.start, selectionInfo.start + 1).match(/ /)) selectionInfo.start++;
    if (textarea.val().substring(selectionInfo.end - 1, selectionInfo.end).match(/ /)) selectionInfo.end--;
    var selection = textarea.val().substring(selectionInfo.start, selectionInfo.end);
    // Work out the text to insert over the selection.
    selection = selection ? selection : (defaultArgumentValue ? defaultArgumentValue : "");
    var text = tagStart + selection + (typeof tagEnd != "undefined" ? tagEnd : tagStart);
    // Replace the textarea's value.
    textarea.val(textarea.val().substr(0, selectionInfo.start) + text + textarea.val().substr(selectionInfo.end));
    // Scroll back down and refocus on the textarea.
    textarea.focus();
    // If a selectArgument was passed, work out where it is and select it. Otherwise, select the text that was selected
    // before this function was called.
    if (selectArgument) {
        var newStart = selectionInfo.start + tagStart.indexOf(selectArgument);
        var newEnd = newStart + selectArgument.length;
    } else {
        var newStart = selectionInfo.start + tagStart.length;
        var newEnd = newStart + selection.length;
    }
    textarea.selectRange(newStart, newEnd);
    // Trigger the textarea's keyup to emulate typing.
    textarea.trigger("keyup");
}


/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2013 Brian Cherne
 */

/* hoverIntent is similar to jQuery's built-in "hover" method except that
 * instead of firing the handlerIn function immediately, hoverIntent checks
 * to see if the user's mouse has slowed down (beneath the sensitivity
 * threshold) before firing the event. The handlerOut function is only
 * called after a matching handlerIn.
 *
 * // basic usage ... just like .hover()
 * .hoverIntent( handlerIn, handlerOut )
 * .hoverIntent( handlerInOut )
 *
 * // basic usage ... with event delegation!
 * .hoverIntent( handlerIn, handlerOut, selector )
 * .hoverIntent( handlerInOut, selector )
 *
 * // using a basic configuration object
 * .hoverIntent( config )
 *
 * @param  handlerIn   function OR configuration object
 * @param  handlerOut  function OR selector for delegation OR undefined
 * @param  selector    selector OR undefined
 * @author Brian Cherne <brian(at)cherne(dot)net>
 */
(function($) {
    $.fn.hoverIntent = function(handlerIn,handlerOut,selector) {

        // default configuration values
        var cfg = {
            interval: 100,
            sensitivity: 7,
            timeout: 0
        };

        if ( typeof handlerIn === "object" ) {
            cfg = $.extend(cfg, handlerIn );
        } else if ($.isFunction(handlerOut)) {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerOut, selector: selector } );
        } else {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerIn, selector: handlerOut } );
        }

        // instantiate variables
        // cX, cY = current X and Y position of mouse, updated by mousemove event
        // pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
        var cX, cY, pX, pY;

        // A private function for getting mouse position
        var track = function(ev) {
            cX = ev.pageX;
            cY = ev.pageY;
        };

        // A private function for comparing current and previous mouse position
        var compare = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            // compare mouse positions to see if they've crossed the threshold
            if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
                $(ob).off("mousemove.hoverIntent",track);
                // set hoverIntent state to true (so mouseOut can be called)
                ob.hoverIntent_s = 1;
                return cfg.over.apply(ob,[ev]);
            } else {
                // set previous coordinates for next time
                pX = cX; pY = cY;
                // use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
                ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
            }
        };

        // A private function for delaying the mouseOut function
        var delay = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            ob.hoverIntent_s = 0;
            return cfg.out.apply(ob,[ev]);
        };

        // A private function for handling mouse 'hovering'
        var handleHover = function(e) {
            // copy objects to be passed into t (required for event object to be passed in IE)
            var ev = jQuery.extend({},e);
            var ob = this;

            // cancel hoverIntent timer if it exists
            if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }

            // if e.type == "mouseenter"
            if (e.type == "mouseenter") {
                // set "previous" X and Y position based on initial entry point
                pX = ev.pageX; pY = ev.pageY;
                // update "current" X and Y position based on mousemove
                $(ob).on("mousemove.hoverIntent",track);
                // start polling interval (self-calling timeout) to compare mouse coordinates over time
                if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}

                // else e.type == "mouseleave"
            } else {
                // unbind expensive mousemove event
                $(ob).off("mousemove.hoverIntent",track);
                // if hoverIntent state is true, then call the mouseOut function after the specified delay
                if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
            }
        };

        // listen for mouseenter and mouseleave
        return this.on({'mouseenter.hoverIntent':handleHover,'mouseleave.hoverIntent':handleHover}, cfg.selector);
    };
})(jQuery);

/*! jQuery Color v@2.1.1 http://github.com/jquery/jquery-color | jquery.org/license */
(function(a,b){function m(a,b,c){var d=h[b.type]||{};return a==null?c||!b.def?null:b.def:(a=d.floor?~~a:parseFloat(a),isNaN(a)?b.def:d.mod?(a+d.mod)%d.mod:0>a?0:d.max<a?d.max:a)}function n(b){var c=f(),d=c._rgba=[];return b=b.toLowerCase(),l(e,function(a,e){var f,h=e.re.exec(b),i=h&&e.parse(h),j=e.space||"rgba";if(i)return f=c[j](i),c[g[j].cache]=f[g[j].cache],d=c._rgba=f._rgba,!1}),d.length?(d.join()==="0,0,0,0"&&a.extend(d,k.transparent),c):k[b]}function o(a,b,c){return c=(c+1)%1,c*6<1?a+(b-a)*c*6:c*2<1?b:c*3<2?a+(b-a)*(2/3-c)*6:a}var c="backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor",d=/^([\-+])=\s*(\d+\.?\d*)/,e=[{re:/rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,parse:function(a){return[a[1],a[2],a[3],a[4]]}},{re:/rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,parse:function(a){return[a[1]*2.55,a[2]*2.55,a[3]*2.55,a[4]]}},{re:/#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/,parse:function(a){return[parseInt(a[1],16),parseInt(a[2],16),parseInt(a[3],16)]}},{re:/#([a-f0-9])([a-f0-9])([a-f0-9])/,parse:function(a){return[parseInt(a[1]+a[1],16),parseInt(a[2]+a[2],16),parseInt(a[3]+a[3],16)]}},{re:/hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,space:"hsla",parse:function(a){return[a[1],a[2]/100,a[3]/100,a[4]]}}],f=a.Color=function(b,c,d,e){return new a.Color.fn.parse(b,c,d,e)},g={rgba:{props:{red:{idx:0,type:"byte"},green:{idx:1,type:"byte"},blue:{idx:2,type:"byte"}}},hsla:{props:{hue:{idx:0,type:"degrees"},saturation:{idx:1,type:"percent"},lightness:{idx:2,type:"percent"}}}},h={"byte":{floor:!0,max:255},percent:{max:1},degrees:{mod:360,floor:!0}},i=f.support={},j=a("<p>")[0],k,l=a.each;j.style.cssText="background-color:rgba(1,1,1,.5)",i.rgba=j.style.backgroundColor.indexOf("rgba")>-1,l(g,function(a,b){b.cache="_"+a,b.props.alpha={idx:3,type:"percent",def:1}}),f.fn=a.extend(f.prototype,{parse:function(c,d,e,h){if(c===b)return this._rgba=[null,null,null,null],this;if(c.jquery||c.nodeType)c=a(c).css(d),d=b;var i=this,j=a.type(c),o=this._rgba=[];d!==b&&(c=[c,d,e,h],j="array");if(j==="string")return this.parse(n(c)||k._default);if(j==="array")return l(g.rgba.props,function(a,b){o[b.idx]=m(c[b.idx],b)}),this;if(j==="object")return c instanceof f?l(g,function(a,b){c[b.cache]&&(i[b.cache]=c[b.cache].slice())}):l(g,function(b,d){var e=d.cache;l(d.props,function(a,b){if(!i[e]&&d.to){if(a==="alpha"||c[a]==null)return;i[e]=d.to(i._rgba)}i[e][b.idx]=m(c[a],b,!0)}),i[e]&&a.inArray(null,i[e].slice(0,3))<0&&(i[e][3]=1,d.from&&(i._rgba=d.from(i[e])))}),this},is:function(a){var b=f(a),c=!0,d=this;return l(g,function(a,e){var f,g=b[e.cache];return g&&(f=d[e.cache]||e.to&&e.to(d._rgba)||[],l(e.props,function(a,b){if(g[b.idx]!=null)return c=g[b.idx]===f[b.idx],c})),c}),c},_space:function(){var a=[],b=this;return l(g,function(c,d){b[d.cache]&&a.push(c)}),a.pop()},transition:function(a,b){var c=f(a),d=c._space(),e=g[d],i=this.alpha()===0?f("transparent"):this,j=i[e.cache]||e.to(i._rgba),k=j.slice();return c=c[e.cache],l(e.props,function(a,d){var e=d.idx,f=j[e],g=c[e],i=h[d.type]||{};if(g===null)return;f===null?k[e]=g:(i.mod&&(g-f>i.mod/2?f+=i.mod:f-g>i.mod/2&&(f-=i.mod)),k[e]=m((g-f)*b+f,d))}),this[d](k)},blend:function(b){if(this._rgba[3]===1)return this;var c=this._rgba.slice(),d=c.pop(),e=f(b)._rgba;return f(a.map(c,function(a,b){return(1-d)*e[b]+d*a}))},toRgbaString:function(){var b="rgba(",c=a.map(this._rgba,function(a,b){return a==null?b>2?1:0:a});return c[3]===1&&(c.pop(),b="rgb("),b+c.join()+")"},toHslaString:function(){var b="hsla(",c=a.map(this.hsla(),function(a,b){return a==null&&(a=b>2?1:0),b&&b<3&&(a=Math.round(a*100)+"%"),a});return c[3]===1&&(c.pop(),b="hsl("),b+c.join()+")"},toHexString:function(b){var c=this._rgba.slice(),d=c.pop();return b&&c.push(~~(d*255)),"#"+a.map(c,function(a){return a=(a||0).toString(16),a.length===1?"0"+a:a}).join("")},toString:function(){return this._rgba[3]===0?"transparent":this.toRgbaString()}}),f.fn.parse.prototype=f.fn,g.hsla.to=function(a){if(a[0]==null||a[1]==null||a[2]==null)return[null,null,null,a[3]];var b=a[0]/255,c=a[1]/255,d=a[2]/255,e=a[3],f=Math.max(b,c,d),g=Math.min(b,c,d),h=f-g,i=f+g,j=i*.5,k,l;return g===f?k=0:b===f?k=60*(c-d)/h+360:c===f?k=60*(d-b)/h+120:k=60*(b-c)/h+240,h===0?l=0:j<=.5?l=h/i:l=h/(2-i),[Math.round(k)%360,l,j,e==null?1:e]},g.hsla.from=function(a){if(a[0]==null||a[1]==null||a[2]==null)return[null,null,null,a[3]];var b=a[0]/360,c=a[1],d=a[2],e=a[3],f=d<=.5?d*(1+c):d+c-d*c,g=2*d-f;return[Math.round(o(g,f,b+1/3)*255),Math.round(o(g,f,b)*255),Math.round(o(g,f,b-1/3)*255),e]},l(g,function(c,e){var g=e.props,h=e.cache,i=e.to,j=e.from;f.fn[c]=function(c){i&&!this[h]&&(this[h]=i(this._rgba));if(c===b)return this[h].slice();var d,e=a.type(c),k=e==="array"||e==="object"?c:arguments,n=this[h].slice();return l(g,function(a,b){var c=k[e==="object"?a:b.idx];c==null&&(c=n[b.idx]),n[b.idx]=m(c,b)}),j?(d=f(j(n)),d[h]=n,d):f(n)},l(g,function(b,e){if(f.fn[b])return;f.fn[b]=function(f){var g=a.type(f),h=b==="alpha"?this._hsla?"hsla":"rgba":c,i=this[h](),j=i[e.idx],k;return g==="undefined"?j:(g==="function"&&(f=f.call(this,j),g=a.type(f)),f==null&&e.empty?this:(g==="string"&&(k=d.exec(f),k&&(f=j+parseFloat(k[2])*(k[1]==="+"?1:-1))),i[e.idx]=f,this[h](i)))}})}),f.hook=function(b){var c=b.split(" ");l(c,function(b,c){a.cssHooks[c]={set:function(b,d){var e,g,h="";if(a.type(d)!=="string"||(e=n(d))){d=f(e||d);if(!i.rgba&&d._rgba[3]!==1){g=c==="backgroundColor"?b.parentNode:b;while((h===""||h==="transparent")&&g&&g.style)try{h=a.css(g,"backgroundColor"),g=g.parentNode}catch(j){}d=d.blend(h&&h!=="transparent"?h:"_default")}d=d.toRgbaString()}try{b.style[c]=d}catch(j){}}},a.fx.step[c]=function(b){b.colorInit||(b.start=f(b.elem,c),b.end=f(b.end),b.colorInit=!0),a.cssHooks[c].set(b.elem,b.start.transition(b.end,b.pos))}})},f.hook(c),a.cssHooks.borderColor={expand:function(a){var b={};return l(["Top","Right","Bottom","Left"],function(c,d){b["border"+d+"Color"]=a}),b}},k=a.Color.names={aqua:"#00ffff",black:"#000000",blue:"#0000ff",fuchsia:"#ff00ff",gray:"#808080",green:"#008000",lime:"#00ff00",maroon:"#800000",navy:"#000080",olive:"#808000",purple:"#800080",red:"#ff0000",silver:"#c0c0c0",teal:"#008080",white:"#ffffff",yellow:"#ffff00",transparent:[null,null,null,0],_default:"#ffffff"}})(jQuery);
