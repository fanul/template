var timeoutWindow = 5000;
	
function showSukses(pesan,fungsi){
    html = '<div id="sukses"><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>' + pesan + '</div>';
	
    $('#head').append(html);
    $('#sukses').dialog({
        close: function(event, ui) {
            $(this).remove()
        },
        draggable: false,
        show: 'clip',
        title: 'Operasi Sukses',
        resizable: false,
        hide: 'fade',
        modal: true,
        buttons: {
            Ok: function() {
                $( this ).dialog('close');
                if (typeof fungsi == 'function'){
                    fungsi()
                }
            }
        }
    });
//setTimeout("$('#sukses').dialog('close');", timeoutWindow);	
}

function showe()
{
    html = '<div id="tes"><h1>Hayoo</h1></div>';
    $('#body').append(html);
    alert(html);
}

function showError(pesan){
    html = '<div id="error"><div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span><strong>Error! </strong>' + pesan + '</p></div>';
    
    $('#head').append(html);
    $('#error').dialog({
        close: function(event, ui) {
            $(this).remove()
        },
        draggable: false,
        show: 'clip',
        title: 'Operasi Gagal',
        resizable: false,
        width: 450,
        hide: 'fade',
        modal: true,
        buttons: {
            Ok: function() {
                $( this ).dialog('close');
            }
        }
    });
    setTimeout("$('#error').dialog('close');", timeoutWindow);	
}

function showLoading(){
    html = '<div id="loading" align="center"><img src="images/icon_loading.gif" /><br /><br />Loading...</div>';
    $('#head').append(html);
    $('#loading').dialog({
        close: function(event, ui) {
            $(this).remove()
        },
        draggable: false,
        show: 'fade',
        title: 'Please Wait!',
        resizable: false,
        hide: 'fade'
    });
}

function showConnection(pesan){
    html = '<div id="conn" align="center">'+ pesan +'</div>';
    $('#head').append(html);
    $('#conn').dialog({
        close: function(event, ui) {
            $(this).remove()
        },
        draggable: false,
        show: 'fade',
        title: 'Please Wait!',
        resizable: false,
        hide: 'fade',
        modal: true
    });
}

function hideLoading(){
    $('#loading').dialog('close');
}
function ajaxError(xhr,ajaxOptions,thrownError){
    showError('<br>Kode Error : ' + xhr.status + '<br>' + thrownError + '<br>' + xhr.responseText);
}

function AddWidget(title,idwidget,col,wcolor,ico) {
    //ico = typeof(ico) != 'undefined' ? ico : 'images/logo-icon-diva-24.png';
    while ($("#"+idwidget).length == 0)
        iNettuts.addWidget("#"+ col, {
            id: idwidget,
            color: wcolor,
            title: title
        });
}

function loadPage(divId,Url,post){
    $(divId).html("<center><img src='"+mainURL+"images/load.gif'/></center>");
    $.ajax({
        type: "POST",
        url: Url,
        data: post + '&nocache=' + Math.random(),
        success: function(html){
            if(html!='')
                $(divId).html(html);
            else
            {
                alert('anda tidak mempunyai akses');
                location.reload();
            }
        },
        error: function(xhr,ajaxOptions,thrownError){
            ajaxError(xhr,ajaxOptions,thrownError);
        }
    })	
}

function appendPage(divId,Url){
    $.ajax({
        type: "POST",
        url: Url,
        success: function(html){
            $(divId).append(html);
        },
        error: function(xhr,ajaxOptions,thrownError){
            ajaxError(xhr,ajaxOptions,thrownError);
        }
    })	
}

function cekcombo(val)
{
    if(val != 0)
        return true;
    else          
        return false;
}