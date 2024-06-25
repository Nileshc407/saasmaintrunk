/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */
var tour = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'hopscotch-title',
      title: 'Click Here For Menu Options',
      // content: 'Click Here For Menu Options',
      placement: 'right',
      arrowOffset:0,
	  
	   yOffset: -20
    },    
    {
      target: 'menu-icon',
      placement: 'top',
      title: 'View our menu and place your orders',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:-80,
	   yOffset: 20
    },    
    {
      target: 'offer-icon',
      placement: 'top',
      title: 'Get updated on our Latest Offers that are',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:-90,
	   yOffset:15
    }
  ],
  showPrevButton: true,
  scrollTopMargin: 100
},

/* ========== */
/* TOUR SETUP */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
  }
},

init = function() {
  var startBtnId = 'startTourBtn',
      calloutId = 'startTourCallout',
      mgr = hopscotch.getCalloutManager(),
      state = hopscotch.getState();

  if (state && state.indexOf('hello-hopscotch:') === 0) {
    // Already started the tour at some point!
    hopscotch.startTour(tour);
  }
  else {
    // Looking at the page for the first(?) time.
    setTimeout(function() {
      mgr.createCallout({
        id: calloutId,
        target: startBtnId,
        placement: 'bottom',
        title: 'Take an tour',
        content: 'Start by clicking an tour to see in action!',
        yOffset: -10,
        arrowOffset: 20,
        width: 240
      });
    }, 100);
  }

  addClickListener(document.getElementById(startBtnId), function() {
    if (!hopscotch.isActive) {
      mgr.removeAllCallouts();
      hopscotch.startTour(tour);
    }
  });
};

init();

