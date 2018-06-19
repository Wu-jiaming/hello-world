@extends('admin.master')

@section('content')
<form class="form form-horizontal" id="form-category-add">

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" value="" placeholder="" id="" name="name">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>序号：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" autocomplete="off" value="" placeholder="" id="" name="category_no">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">父类别：</label>
        <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="parent_id" size="1">
				<option value="">无</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
			    @endforeach
            </select>
			</span> </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">预览图</label>
        <div class="formControls col-xs-4 col-sm-5">
            <img id="preview_id" src="{{url('/admin/static/h-ui.admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 100px;height: 100px; cursor: pointer;" onclick="$('#input_id').click()"/>
            <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images','preview_id')"/>
        </div>
    </div>
    <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
            <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        </div>
    </div>
</form>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{url('/admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{url('/admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{url('/admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<!--上传图片脚本-->
{{--<script type="text/javascript" src="{{url('/admin/static/h-ui.admin/js/uploadFile.js')}}"></script>--}}
@stop

@section('my-js')
<script type="text/javascript">

    $("#form-category-add").validate({
        rules:{
            name:{
                required:true,
                minlength:1,
                maxlength:16
            },
            category_no:{
                required:true,
                minlength:1,
                maxlength:16
            },
        },
        onkeyup:false,
        focusCleanup:true,
        success:"valid",
        submitHandler:function(form){
            $(form).ajaxSubmit({
                type: 'post',
                url: '{{url('/admin/service/category/add')}}' ,
                dataType:'json',
                data: {name:$('input[name=name]').val(),
                        category_no:$('input[name=category_no]').val(),
                        parent_id:$('select[name=parent_id] option:selected').val(),
                        image:($('#preview_id').attr('src')!='{{url('/admin/static/h-ui.admin/images/icon-add.png')}}' ? $('#preview_id').attr('src') : ''),
                        _token:"{{csrf_token()}}"
                },

                success: function(data){

                    if(data==null){
                        layer.msg('服务器错误!',{icon:2,time:5000});
                        return;
                    }
                    if (data.status != 0){
                        layer.msg(data.message,{icon:2,time:5000});
                    }
                    layer.msg('添加成功!',{icon:1,time:2000});
                    parent.location.reload();
/*                    var index = parent.layer.getFrameIndex(window.name);
                    parent.$('.btn-refresh').click();
                    parent.layer.close(index);*/


                },
                error: function(XmlHttpRequest, textStatus, errorThrown){
                    layer.msg('error!',{icon:2,time:5000});
                    console.log(XmlHttpRequest);
                    console.log(textStatus);
                    console.log(errorThrown);

                }

        });

        }
    });



    function uploadFileToServer(fileElmId, type, id)
    {
        $.ajaxFileUpload({
            url:  "{{url('/admin/service/upload/')}}"+"/"+ type,
            fileElementId: fileElmId,
            dataType: 'text',
            success: function (data)
            {

                var result = JSON.parse(data);
                $("#"+id).val(result.uri);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
        return false;
    }

    function uploadImageToServer(fileElmId, type, id)
    {
        $("#"+id).attr("src", "{{url('/admin/static/h-ui.admin/images/loading.gif')}}");
        $.ajaxFileUpload({
            url: "{{url('/admin/service/upload/')}}"+"/" + type,
            fileElementId: fileElmId,
            dataType: 'text',
            success: function (data)
            {
                var result = JSON.parse(data);
                $("#"+id).attr("src",  "{{url('')}}"+"/" +result.uri);
                alert(result.uri);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
        return false;
    }

    /// JQuery Extends
    jQuery.extend({

        createUploadIframe: function(id, uri)
        {
            //create frame
            var frameId = 'jUploadFrame' + id;
            var iframeHtml = '<iframe id="' + frameId + '" name="' + frameId + '" style="position:absolute; top:-9999px; left:-9999px"';
            if(window.ActiveXObject)
            {
                if(typeof uri== 'boolean'){
                    iframeHtml += ' src="' + 'javascript:false' + '"';

                }
                else if(typeof uri== 'string'){
                    iframeHtml += ' src="' + uri + '"';

                }
            }
            iframeHtml += ' />';
            jQuery(iframeHtml).appendTo(document.body);

            return jQuery('#' + frameId).get(0);
        },
        createUploadForm: function(id, fileElementId, data)
        {
            //create form
            var formId = 'jUploadForm' + id;
            var fileId = 'jUploadFile' + id;
            var form = jQuery('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');
            if(data)
            {
                for(var i in data)
                {
                    jQuery('<input type="hidden" name="' + i + '" value="' + data[i] + '" />').appendTo(form);
                }
            }
            var oldElement = jQuery('#' + fileElementId);
            var newElement = jQuery(oldElement).clone();
            jQuery(oldElement).attr('id', fileId);
            jQuery(oldElement).before(newElement);
            jQuery(oldElement).appendTo(form);



            //set attributes
            jQuery(form).css('position', 'absolute');
            jQuery(form).css('top', '-1200px');
            jQuery(form).css('left', '-1200px');
            jQuery(form).appendTo('body');
            return form;
        },

        ajaxFileUpload: function(s) {
            // TODO introduce global settings, allowing the client to modify them for all requests, not only timeout
            s = jQuery.extend({}, jQuery.ajaxSettings, s);
            var id = new Date().getTime()
            var form = jQuery.createUploadForm(id, s.fileElementId, (typeof(s.data)=='undefined'?false:s.data));
            var io = jQuery.createUploadIframe(id, s.secureuri);
            var frameId = 'jUploadFrame' + id;
            var formId = 'jUploadForm' + id;
            // Watch for a new set of requests
            if ( s.global && ! jQuery.active++ )
            {
                jQuery.event.trigger( "ajaxStart" );
            }
            var requestDone = false;
            // Create the request object
            var xml = {}
            if ( s.global )
                jQuery.event.trigger("ajaxSend", [xml, s]);
            // Wait for a response to come back
            var uploadCallback = function(isTimeout)
            {
                var io = document.getElementById(frameId);
                try
                {
                    if(io.contentWindow)
                    {
                        xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
                        xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;

                    }else if(io.contentDocument)
                    {
                        xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
                        xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
                    }
                }catch(e)
                {
                    jQuery.handleError(s, xml, null, e);
                }
                if ( xml || isTimeout == "timeout")
                {
                    requestDone = true;
                    var status;
                    try {
                        status = isTimeout != "timeout" ? "success" : "error";
                        // Make sure that the request was successful or notmodified
                        if ( status != "error" )
                        {
                            // process the data (runs the xml through httpData regardless of callback)
                            var data = jQuery.uploadHttpData( xml, s.dataType );
                            // If a local callback was specified, fire it and pass it the data
                            if ( s.success )
                                s.success( data, status );

                            // Fire the global callback
                            if( s.global )
                                jQuery.event.trigger( "ajaxSuccess", [xml, s] );
                        } else
                            jQuery.handleError(s, xml, status);
                    } catch(e)
                    {
                        status = "error";
                        jQuery.handleError(s, xml, status, e);
                    }

                    // The request was completed
                    if( s.global )
                        jQuery.event.trigger( "ajaxComplete", [xml, s] );

                    // Handle the global AJAX counter
                    if ( s.global && ! --jQuery.active )
                        jQuery.event.trigger( "ajaxStop" );

                    // Process result
                    if ( s.complete )
                        s.complete(xml, status);

                    jQuery(io).unbind()

                    setTimeout(function()
                    {	try
                    {
                        jQuery(io).remove();
                        jQuery(form).remove();

                    } catch(e)
                    {
                        jQuery.handleError(s, xml, null, e);
                    }

                    }, 100)

                    xml = null

                }
            }
            // Timeout checker
            if ( s.timeout > 0 )
            {
                setTimeout(function(){
                    // Check to see if the request is still happening
                    if( !requestDone ) uploadCallback( "timeout" );
                }, s.timeout);
            }
            try
            {

                var form = jQuery('#' + formId);
                jQuery(form).attr('action', s.url);
                jQuery(form).attr('method', 'POST');
                jQuery(form).attr('target', frameId);
                if(form.encoding)
                {
                    jQuery(form).attr('encoding', 'multipart/form-data');
                }
                else
                {
                    jQuery(form).attr('enctype', 'multipart/form-data');
                }
                jQuery(form).submit();

            } catch(e)
            {
                jQuery.handleError(s, xml, null, e);
            }

            jQuery('#' + frameId).load(uploadCallback	);
            return {abort: function () {}};

        },

        uploadHttpData: function( r, type ) {
            var data = !type;
            data = type == "xml" || data ? r.responseXML : r.responseText;
            // If the type is "script", eval it in global context
            if ( type == "script" )
                jQuery.globalEval( data );
            // Get the JavaScript object, if JSON is used.
            if ( type == "json" )
                data = jQuery.parseJSON(jQuery(data).text());
            // evaluate scripts within html
            if ( type == "html" )
                jQuery("<div>").html(data).evalScripts();

            return data;
        },

        handleError: function( s, xhr, status, e ) 		{
            // If a local callback was specified, fire it
            console.log("error uploader");

            if ( s.error ) {
                s.error.call( s.context || s, xhr, status, e );
            }

            // Fire the global callback
            if ( s.global ) {
                (s.context ? jQuery(s.context) : jQuery.event).trigger( "ajaxError", [xhr, s, e] );
            }
        }
    })

</script>
@stop