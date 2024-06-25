
// variables
var $header_top = $('.header-top');
var $nav = $('nav');
var sectionsColor_array = ['#B8AE9C', '#222222', '#F2AE72', '#5C832F'];
var color_count = sectionsColor_array.length;

// fullpage customization
$('#fullpage').fullpage(
{
	// sectionsColor: ['#B8AE9C', '#348899', '#F2AE72', '#5C832F', '#B8B89F'],
	sectionsColor: ['#faf2db', '#faf2db', '#faf2db', '#faf2db', '#faf2db'],
	sectionSelector: '.vertical-scrolling',
	slideSelector: '.horizontal-scrolling',
	navigation: true,
	slidesNavigation: true,
	controlArrows: false,
	anchors: ['firstSection', 'secondSection', 'thirdSection', 'fourthSection', 'fifthSection'],
	menu: '#menu',

	afterLoad: function(anchorLink, index) 
	{
		$header_top.css('background', 'rgba(0, 47, 77, .3)');
		$nav.css('background', 'rgba(0, 47, 77, .25)');
	}
});

/* function invertColor(hex) 
{
    if (hex.indexOf('#') === 0) 
	{
        hex = hex.slice(1);
    }
	
    // convert 3-digit hex to 6-digits.
    if (hex.length === 3) 
	{
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
	
    if (hex.length !== 6) 
	{
        throw new Error('Invalid HEX color.');
    }
    // invert color components
    var r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
        g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
        b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
    // pad each with zeros and return
    return "#" + padZero(r) + padZero(g) + padZero(b);
}

function padZero(str, len) 
{
    len = len || 2;
    var zeros = new Array(len).join('0');
    return (zeros + str).slice(-len);
}

function getRandomColor() 
{
    var color = Math.round(Math.random() * 0x1000000).toString(16);
    return "#" + padZero(color, 6);
} */

var i, box, color, bgColor;
var j = 0;
// var color_count = sectionsColor_array.length;
var color_count = 5;
for (i = 0; i < color_count; i++) 
{
	/* j++;
	color = getRandomColor();
	bgColor = invertColor(color);
	
	$("#questionid_" + j).css("background-color",bgColor);
	// $("#questionid_" + j + " h2").css("color",color);
	$("#questionid_" + j).css("color",color);
	
	$("#fp-nav ul li a span, .fp-slidesNav ul li a span").css("background",color);
	$("#fp-nav ul li a, .fp-slidesNav ul li a").css("color",color); */
	
	/* $("input[type=radio]:checked ~ .check").css("color",color);
	$("input[type=radio]:checked ~ .check::before").css("color",color);
	$("input[type=radio]:checked ~ label").css("color",color); */
}
   
$("#fullpage").bind("mousewheel", function() 
{
    return false;
});