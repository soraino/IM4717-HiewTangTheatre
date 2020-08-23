function initSlider(sliderIndex){
    const slider = document.getElementById(`slider${sliderIndex}`);
    const sliderItems = document.getElementById(`slides${sliderIndex}`);
    const prev = document.getElementById(`prev${sliderIndex}`);
    const next = document.getElementById(`next${sliderIndex}`);
    
    function slide(wrapper, items, prev, next) {
        let posX1 = 0;
        let posX2 = 0;
        let posInitial;
        let posFinal;
        let index = 0;
        let allowShift = true;
        const threshold = 10;
        const slides = items.getElementsByClassName("slide");
        const slidesLength = slides.length;
        const slideSize = items.getElementsByClassName("slide")[0].offsetWidth + 20;
    
        // Mouse events
        items.onmousedown = dragStart;
    
        // Touch events
        items.addEventListener("touchstart", dragStart);
        items.addEventListener("touchend", dragEnd);
        items.addEventListener("touchmove", dragAction);
    
        // Click events
        prev.addEventListener("click", function () {
            shiftSlide(-1);
        });
        next.addEventListener("click", function () {
            shiftSlide(1);
        });
    
        // Transition events
        items.addEventListener("transitionend", checkIndex);
    
        function dragStart(e) {
            e = e || window.event;
            e.preventDefault();
            posInitial = items.offsetLeft;
    
            if (e.type == "touchstart") {
                posX1 = e.touches[0].clientX;
            } else {
                posX1 = e.clientX;
                document.onmouseup = dragEnd;
                document.onmousemove = dragAction;
            }
        }
    
        function dragAction(e) {
            e = e || window.event;
    
            if (e.type == "touchmove") {
                posX2 = posX1 - e.touches[0].clientX;
                posX1 = e.touches[0].clientX;
            } else {
                posX2 = posX1 - e.clientX;
                posX1 = e.clientX;
            }
            items.style.left = items.offsetLeft - posX2 + "px";
        }
    
        function dragEnd(e) {
            posFinal = items.offsetLeft;
            if (posFinal - posInitial < -threshold) {
                shiftSlide(1, "drag");
            } else if (posFinal - posInitial > threshold) {
                shiftSlide(-1, "drag");
            } else {
                items.style.left = posInitial + "px";
            }
    
            document.onmouseup = null;
            document.onmousemove = null;
        }
    
        function shiftSlide(dir, action) {
            if (allowShift) {
                if (!action) {
                    posInitial = items.offsetLeft;
                }
    
                if (dir == 1) {
                    if (index == slidesLength - 1) {
                        items.style.left = 0;
                        index = 0;
                    } else {
                        items.style.left = posInitial - slideSize + "px";
                        index++;
                    }
                } else if (dir == -1) {
                    if (index == 0) {
                        const finalIndex = (slidesLength - 1);
                        items.style.left = -(finalIndex * slideSize) + "px";
                        index = finalIndex;
                    } else {
                        items.style.left = posInitial + slideSize + "px";
                        index--;
                    }
                }
            }
        }
    
        function checkIndex() {
            if (index == -1) {
                items.style.left = -((slidesLength - 1) * slideSize) + "px";
                index = slidesLength - 1;
            }
    
            if (index == slidesLength) {
                items.style.left = "0 px";
                index = 0;
            }
    
            allowShift = true;
        }
    }
    slide(slider, sliderItems, prev, next);
    
}
