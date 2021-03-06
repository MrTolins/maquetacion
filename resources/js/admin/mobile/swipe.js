import {deleteElement, editElement} from './form';

export function swipeRevealItem (element){

    'use strict';

    let swipeFrontElement = element.querySelector('.swipe-front');

    let STATE_DEFAULT = 1;
    let STATE_LEFT_SIDE = 2;
    let STATE_RIGHT_SIDE = 3;

    let rafPending = false;
    let initialTouchPos = null;
    let lastTouchPos = null;
    let currentXPosition = 0;
    let currentState = STATE_DEFAULT;
    let handleSize = 10;
    let leftSwipeVisible = 0;
    let rightSwipeVisible = 0;
    let itemWidth = swipeFrontElement.clientWidth;
    let slopValue = itemWidth * (2/4);

    this.resize = function() {
        itemWidth = swipeFrontElement.clientWidth;
        slopValue = itemWidth * (2/4);
    };

    this.handleGestureStart = function(evt) {

        evt.preventDefault();

        if(evt.touches && evt.touches.length > 1) {
            return;
        }

        if (window.PointerEvent) {
            evt.target.setPointerCapture(evt.pointerId);
        } else {
            document.addEventListener('mousemove', this.handleGestureMove, true);
            document.addEventListener('mouseup', this.handleGestureEnd, true);
        }

        initialTouchPos = getGesturePointFromEvent(evt);
        swipeFrontElement.style.transition = 'initial';

    }.bind(this);

    this.handleGestureMove = function (evt) {

        evt.preventDefault();

        if(!initialTouchPos) {
            return;
        }

        lastTouchPos = getGesturePointFromEvent(evt);

        if(rafPending) {
            return;
        }

        rafPending = true;

        window.requestAnimFrame(onAnimFrame);

    }.bind(this);

    this.handleGestureEnd = function(evt) {

        evt.preventDefault();

        if(evt.touches && evt.touches.length > 0) {
            return;
        }

        rafPending = false;

        if (window.PointerEvent) {
            evt.target.releasePointerCapture(evt.pointerId);
        } else {
            document.removeEventListener('mousemove', this.handleGestureMove, true);
            document.removeEventListener('mouseup', this.handleGestureEnd, true);
        }

        updateSwipeRestPosition();

        leftSwipeVisible = 0;
        rightSwipeVisible = 0;
        initialTouchPos = null;

    }.bind(this);

    
    function updateSwipeRestPosition() {

        let differenceInX = initialTouchPos.x - lastTouchPos.x;
        currentXPosition = currentXPosition - differenceInX;

        let newState = STATE_DEFAULT;

       

        if(Math.abs(differenceInX) > slopValue) {
            
            if(currentState === STATE_DEFAULT) {
                if(differenceInX > 0) {
                    newState = STATE_LEFT_SIDE;
                } else {
                    newState = STATE_RIGHT_SIDE;
                }
            } else {
                if(currentState === STATE_LEFT_SIDE && differenceInX > 0) {
                    newState = STATE_DEFAULT;
                } else if(currentState === STATE_RIGHT_SIDE && differenceInX < 0) {
                    newState = STATE_DEFAULT;
                }
            }
        } else {
            newState = currentState;
        }

        changeState(newState);

        swipeFrontElement.style.transition = 'all 150ms ease-out';

        
    }

    function changeState(newState) {

        let transformStyle;

        switch(newState) {

            case STATE_DEFAULT:
                currentXPosition = 0;
            break;

            case STATE_LEFT_SIDE:
                currentXPosition = -(itemWidth - handleSize);
                deleteElement(element.querySelector('.left-swipe').dataset.url);
                newState = STATE_DEFAULT;
            break;

            case STATE_RIGHT_SIDE:
                currentXPosition = itemWidth - handleSize;
                editElement(element.querySelector('.right-swipe').dataset.url);          
                newState = STATE_DEFAULT;
            break;
        }
        
        currentXPosition = 0;

        transformStyle = 'translateX('+currentXPosition+'px)';

        swipeFrontElement.style.msTransform = transformStyle;
        swipeFrontElement.style.MozTransform = transformStyle;
        swipeFrontElement.style.webkitTransform = transformStyle;
        swipeFrontElement.style.transform = transformStyle;

        currentState = newState; 
        
        
    }

    function getGesturePointFromEvent(evt) {

        let point = {};

        if(evt.targetTouches) {
            point.x = evt.targetTouches[0].clientX;
            point.y = evt.targetTouches[0].clientY;
        } else {
            point.x = evt.clientX;
            point.y = evt.clientY;
        }

        return point;
    }

    function onAnimFrame() {

        if(!rafPending) {
            return;
        }

        let differenceInX = initialTouchPos.x - lastTouchPos.x;
        let newXTransform  = (currentXPosition - differenceInX)+'px';
        let transformStyle = 'translateX('+newXTransform+')';

        if(Math.sign(differenceInX) == 1 && leftSwipeVisible == 0){

            let swipeActive = document.getElementById('swipe-active');

            if(swipeActive !== null){
                swipeActive.removeAttribute('id');
            }

            element.querySelector('.left-swipe').id = 'swipe-active';

            leftSwipeVisible = 1;
            rightSwipeVisible = 0;

        }else if(Math.sign(differenceInX) == -1 && rightSwipeVisible == 0){

            let swipeActive = document.getElementById('swipe-active');
 
            if(swipeActive !== null){
                swipeActive.removeAttribute('id');
            }

            element.querySelector('.right-swipe').id = 'swipe-active';

            leftSwipeVisible = 0;
            rightSwipeVisible = 1;
        }

        swipeFrontElement.style.webkitTransform = transformStyle;
        swipeFrontElement.style.MozTransform = transformStyle;
        swipeFrontElement.style.msTransform = transformStyle;
        swipeFrontElement.style.transform = transformStyle;


       

        rafPending = false;
    }
    
    if (window.PointerEvent) {
        swipeFrontElement.addEventListener('pointerdown', this.handleGestureStart, false);
        swipeFrontElement.addEventListener('pointermove', this.handleGestureMove, false);
        swipeFrontElement.addEventListener('pointerup', this.handleGestureEnd, false);
        swipeFrontElement.addEventListener('pointercancel', this.handleGestureEnd, false);
    } else {
        swipeFrontElement.addEventListener('touchstart', this.handleGestureStart, false);
        swipeFrontElement.addEventListener('touchmove', this.handleGestureMove, false);
        swipeFrontElement.addEventListener('touchend', this.handleGestureEnd, false);
        swipeFrontElement.addEventListener('touchcancel', this.handleGestureEnd, false);
        swipeFrontElement.addEventListener('mousedown', this.handleGestureStart, false);
    }    
    
};   