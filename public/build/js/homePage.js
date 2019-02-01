function adpaterALaTailleDeLaFenetre(){
    var largeur = document.documentElement.clientWidth;
    var hauteur = document.documentElement.clientHeight-document.getElementById('headerSize').clientHeight;
    var centre = (((document.documentElement.clientHeight-document.getElementById('headerSize').clientHeight)/2)-150).toString()+"px";
    const source = document.getElementById('first-view-js');
    source.style.height = hauteur+'px';
    source.style.width = largeur+'px';
    source.style.backgroundColor= 'purple';
    source.style.textAlign='center';
    source.style.paddingTop= centre;
}

function addEvent(element, type, listener){
    if(element.addEventListener){
        element.addEventListener(type, listener, false);
    }
}


addEvent(window, "load", adpaterALaTailleDeLaFenetre);

addEvent(window, "resize", adpaterALaTailleDeLaFenetre);