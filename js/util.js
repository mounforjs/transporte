
//Funcion para saltar al proximo campo, al pulsar enter.
function tabular(e,obj)
{
  tecla=(document.all) ? e.keyCode : e.which;
            if(tecla!=13) return;
            frm=obj.form;
            for(i=0;i<frm.elements.length;i++)
                if(frm.elements[i]==obj)
                {
                    if (i==frm.elements.length-1)
                        i=-1;
                    break
                }
    /*ACA ESTA EL CAMBIO disabled, Y PARA SALTEAR CAMPOS HIDDEN*/
            if ((frm.elements[i+1].disabled ==true) || (frm.elements[i+1].type=='hidden') )
                tabular(e,frm.elements[i+1]);
    /*ACA ESTA EL CAMBIO readOnly */
            else if (frm.elements[i+1].readOnly ==true )
                tabular(e,frm.elements[i+1]);
            else frm.elements[i+1].focus();
            return false;
}


