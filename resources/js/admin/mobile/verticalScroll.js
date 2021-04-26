export function scrollWindowElement(element){

    'use strict';

    let scrollWindowElement = element;

    let STATE_DEFAULT = 1;
    let STATE_TOP_SIDE = 2;
    let STATE_BOTTOM_SIDE = 3;

    let rafPending = false;
    let initialTouchPos = null;
    let lastTouchPos = null;
    let currentYPosition = 0;
    let currentState = STATE_DEFAULT;
    let handleSize = 10;

    this.handleGestureStart = function(evt) { //el evt esta recogiendo el evento de tocar

        //solo hay un evento de touch
        if(evt.touches && evt.touches.length > 1) {
            return;
        }
        //para poder utilizar desde ordenador
        if (scrollWindowElement.PointerEvent) {
            evt.target.setPointerCapture(evt.pointerId);
        } else {
            document.addEventListener('mousemove', this.handleGestureMove, true);
            document.addEventListener('mouseup', this.handleGestureEnd, true);
        }
        //valor en el eje vertical donde has pulsado
        initialTouchPos = getGesturePointFromEvent(evt);

    }.bind(this);

    //ffuncion que gestionará el movimiento del dedo
    this.handleGestureMove = function (evt) {

        //si no se tocado initial touch
        if(!initialTouchPos) {
            return;
        }

        //captura donde te estás moviendo
        lastTouchPos = getGesturePointFromEvent(evt);

        //si rafPending vale falso no es verdadero
        if(rafPending) {
            return;
        }
        //cuando lo conviertes a true ya no puede volver atrás
        rafPending = true;

        //la ventana(html) Hacer mas fluidas la animaciones gracias a la función AnimFrame
        //esta función está localizada en bootstrap
        //onAnimeFrame es una función recogida dentro de otra función
        //AnimFrameRequest lo va a cargar lo primero
        window.requestAnimFrame(onAnimFrame);

    }.bind(this);

    this.handleGestureEnd = function(evt) {

        

        if(evt.touches && evt.touches.length > 0) {
            return;
        }

        rafPending = false;

        if (scrollWindowElement.PointerEvent) {
            evt.target.releasePointerCapture(evt.pointerId);
        } else {
            document.removeEventListener('mousemove', this.handleGestureMove, true);
            document.removeEventListener('mouseup', this.handleGestureEnd, true);
        }

        updateScrollRestPosition();

        
        initialTouchPos = null;

    }.bind(this);


    function updateScrollRestPosition() {

        let transformStyle;
        let differenceInY = initialTouchPos.y - lastTouchPos.y;
        
        currentYPosition = currentYPosition - differenceInY;

        transformStyle = currentYPosition+'px';
        scrollWindowElement.style.top = transformStyle;
        scrollWindowElement.style.transition = 'all 300ms ease-out';

        console.log(scrollWindowElement.offsetTop);
        console.log(scrollWindowElement.getBoundingClientRect());
    }

    function getGesturePointFromEvent(evt) {

        let point = {}; //json
        //dentro del json point hay una clave que será "y"
        //"y" tiene como valor el evento de tocar, para saber donde he tocado

        if(evt.targetTouches) {
            point.y = evt.targetTouches[0].clientY;
        } else { //coges la posicion de y
            point.y = evt.clientY;
        }

        return point; 

    }

    function onAnimFrame() {

        //si es falso no seguirá con el código

        if(!rafPending) {
            return;
        }

        //mira la diferencia entra la posición inicial y la posición final

        let differenceInY = initialTouchPos.y - lastTouchPos.y;
        //el movimiento que voy a hacer en pixeles
        let transformStyle  = (currentYPosition - differenceInY)+'px';
        //codigo para limitar que puedas subir más de la cuenta la tabla de mobil
        //si differenceInY es menor que 1, pregunta si en tu css el atributo top es mayor que 0 px
        //si es mayor, se quedará en 0 px, si es menor, seguirá hacia arriba


        //limitar el bottom de la tabla cuando se acaben los productos
        //cuando llegas al limite de los productos llamas a pagination() PaginationVisible=true para evitar que lance muchas veces
        //

        scrollWindowElement.style.top = transformStyle;
        
        
        rafPending = false;
    }

    

    //Cuatro eventos son llamados por la tabla (scrollWindowElement)
    //passive:true para evitar que vaya a tirones el scroll
    scrollWindowElement.addEventListener('touchstart', this.handleGestureStart, {passive: true} );
    scrollWindowElement.addEventListener('touchmove', this.handleGestureMove, {passive: true} );
    scrollWindowElement.addEventListener('touchend', this.handleGestureEnd, true);
    scrollWindowElement.addEventListener('touchcancel', this.handleGestureEnd, true);
};   