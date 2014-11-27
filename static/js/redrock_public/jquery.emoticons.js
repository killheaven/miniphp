/**
 * jQuery's jqfaceedit Plugin
 *
 * @author cdm
 * @version 0.2
 * @copyright Copyright(c) 2012.
 * @date 2012-08-09
 */
(function($) {
    var em = [
                {'id':1,'phrase':'[呵呵]','url':'../static/images/emotions/1.gif'},{'id':2,'phrase':'[嘻嘻]','url':'../static/images/emotions/2.gif'},
                {'id':3,'phrase':'[哈哈]','url':'../static/images/emotions/3.gif'},{'id':4,'phrase':'[可爱]','url':'../static/images/emotions/4.gif'},
                {'id':5,'phrase':'[可怜]','url':'../static/images/emotions/5.gif'},{'id':6,'phrase':'[挖鼻孔]','url':'../static/images/emotions/6.gif'},
                {'id':7,'phrase':'[吃惊]','url':'../static/images/emotions/7.gif'},{'id':8,'phrase':'[害羞]','url':'../static/images/emotions/8.gif'},
                {'id':9,'phrase':'[挤眼]','url':'../static/images/emotions/9.gif'},{'id':10,'phrase':'[闭嘴]','url':'../static/images/emotions/10.gif'},
                {'id':11,'phrase':'[鄙视]','url':'../static/images/emotions/11.gif'},{'id':12,'phrase':'[爱你]','url':'../static/images/emotions/12.gif'},
                {'id':13,'phrase':'[流泪]','url':'../static/images/emotions/13.gif'},{'id':14,'phrase':'[偷笑]','url':'../static/images/emotions/14.gif'},
                {'id':15,'phrase':'[亲亲]','url':'../static/images/emotions/15.gif'},{'id':16,'phrase':'[生病]','url':'../static/images/emotions/16.gif'},
                {'id':17,'phrase':'[开心]','url':'../static/images/emotions/17.gif'},{'id':18,'phrase':'[懒得理你]','url':'../static/images/emotions/18.gif'},
                {'id':19,'phrase':'[左哼哼]','url':'../static/images/emotions/19.gif'},{'id':20,'phrase':'[右哼哼]','url':'../static/images/emotions/20.gif'},
                {'id':21,'phrase':'[嘘]','url':'../static/images/emotions/21.gif'},{'id':22,'phrase':'[衰]','url':'../static/images/emotions/22.gif'},
                {'id':23,'phrase':'[委屈]','url':'../static/images/emotions/23.gif'},{'id':24,'phrase':'[吐]','url':'../static/images/emotions/24.gif'},
                {'id':25,'phrase':'[打哈欠]','url':'../static/images/emotions/25.gif'},{'id':26,'phrase':'[抱抱]','url':'../static/images/emotions/26.gif'},
                {'id':27,'phrase':'[怒]','url':'../static/images/emotions/27.gif'},{'id':28,'phrase':'[疑问]','url':'../static/images/emotions/28.gif'},
                {'id':29,'phrase':'[馋嘴]','url':'../static/images/emotions/29.gif'},{'id':30,'phrase':'[拜拜]','url':'../static/images/emotions/30.gif'},
                {'id':31,'phrase':'[思考]','url':'../static/images/emotions/31.gif'},{'id':32,'phrase':'[汗]','url':'../static/images/emotions/32.gif'},
                {'id':33,'phrase':'[困]','url':'../static/images/emotions/33.gif'},{'id':34,'phrase':'[睡觉]','url':'../static/images/emotions/34.gif'},
                {'id':35,'phrase':'[钱]','url':'../static/images/emotions/35.gif'},{'id':36,'phrase':'[失望]','url':'../static/images/emotions/36.gif'},
                {'id':37,'phrase':'[酷]','url':'../static/images/emotions/37.gif'},{'id':38,'phrase':'[花心]','url':'../static/images/emotions/38.gif'},
                {'id':39,'phrase':'[哼]','url':'../static/images/emotions/39.gif'},{'id':40,'phrase':'[鼓掌]','url':'../static/images/emotions/40.gif'},
                {'id':41,'phrase':'[晕]','url':'../static/images/emotions/41.gif'},{'id':42,'phrase':'[悲伤]','url':'../static/images/emotions/42.gif'},
                {'id':43,'phrase':'[抓狂]','url':'../static/images/emotions/43.gif'},{'id':44,'phrase':'[黑线]','url':'../static/images/emotions/44.gif'},
                {'id':45,'phrase':'[阴脸]','url':'../static/images/emotions/45.gif'},{'id':46,'phrase':'[怒骂]','url':'../static/images/emotions/46.gif'},
                {'id':47,'phrase':'[心]','url':'../static/images/emotions/47.gif'},{'id':48,'phrase':'[伤心]','url':'../static/images/emotions/48.gif'},
                {'id':49,'phrase':'[猪头]','url':'../static/images/emotions/49.gif'},{'id':50,'phrase':'[OK]','url':'../static/images/emotions/50.gif'},
                {'id':51,'phrase':'[耶]','url':'../static/images/emotions/51.gif'},{'id':52,'phrase':'[good]','url':'../static/images/emotions/52.gif'},
                {'id':53,'phrase':'[不要]','url':'../static/images/emotions/53.gif'},{'id':54,'phrase':'[赞]','url':'../static/images/emotions/54.gif'},
                {'id':55,'phrase':'[来]','url':'../static/images/emotions/55.gif'},{'id':56,'phrase':'[弱]','url':'../static/images/emotions/56.gif'},
                {'id':57,'phrase':'[蜡烛]','url':'../static/images/emotions/57.gif'},{'id':58,'phrase':'[钟]','url':'../static/images/emotions/58.gif'},
                {'id':59,'phrase':'[蛋糕]','url':'../static/images/emotions/59.gif'},{'id':60,'phrase':'[话筒]','url':'../static/images/emotions/60.gif'}
            ];
    //textarea设置光标位置
    function setCursorPosition(ctrl, pos) {
        if(ctrl.setSelectionRange) {
            ctrl.focus();
            ctrl.setSelectionRange(pos, pos);
        } else if(ctrl.createTextRange) {// IE Support
            var range = ctrl.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    }

    //获取多行文本框光标位置
    function getPositionForTextArea(obj)
    {
        var Sel = document.selection.createRange();
        var Sel2 = Sel.duplicate();
        Sel2.moveToElementText(obj);
        var CaretPos = -1;
        while(Sel2.inRange(Sel)) {
            Sel2.moveStart('character');
            CaretPos++;
        }
       return CaretPos ;

    }

    $.fn.extend({
        jqfaceedit : function(options) {
            var defaults = {
                txtAreaObj : '', //TextArea对象
                containerObj : '', //表情框父对象
                textareaid: 'msg',//textarea元素的id
                popName : '', //iframe弹出框名称,containerObj为父窗体时使用
                emotions : em, //表情信息json格式，id表情排序号 phrase表情使用的替代短语url表情文件名
                top : 0, //相对偏移
                left : 0 //相对偏移
            };
            
            var options = $.extend(defaults, options);
            var cpos=0;//光标位置，支持从光标处插入数据
            var textareaid = options.textareaid;
            
            return this.each(function() {
                var Obj = $(this);
               // var container = document.body;
				var container = options.containerObj;
                if ( document.selection ) {//ie
                    options.txtAreaObj.bind("click keyup",function(e){//点击或键盘动作时设置光标值
                        e.stopPropagation();
                        cpos = getPositionForTextArea(document.getElementById(textareaid)?document.getElementById(textareaid):window.frames[options.popName].document.getElementById(textareaid));
                    });
                }
                $(Obj).bind("click", function(e) {
                    e.stopPropagation();
                    var faceHtml = '<div id="face">';
                    faceHtml += '<div id="texttb"><a class="f_close" title="关闭" href="javascript:void(0);"></a></div>';
                    faceHtml += '<div id="facebox">';
                    faceHtml += '<div id="face_detail" class="facebox clearfix"><ul>';

                    for( i = 0; i < options.emotions.length; i++) {
                        faceHtml += '<li text=' + options.emotions[i].phrase + ' type=' + i + '><img title=' + options.emotions[i].phrase + ' src="emotions/'+ options.emotions[i].url + '"  style="cursor:pointer; position:relative;"   /></li>';
                    }
                    faceHtml += '</ul></div>';
                    faceHtml += '</div><div class="arrow arrow_t"></div></div>';

                    container.find('#face').remove();
                    container.append(faceHtml);
                    
                    container.find("#face_detail ul >li").bind("click", function(e) {
                        var txt = $(this).attr("text");
                        var faceText = txt;

                        //options.txtAreaObj.val(options.txtAreaObj.val() + faceText);
                        var tclen = options.txtAreaObj.val().length;
                        
                        var tc = document.getElementById(textareaid);
                        if ( options.popName ) {
                            tc = window.frames[options.popName].document.getElementById(textareaid);
                        }
                        var pos = 0;
                        if( typeof document.selection != "undefined") {//IE
                            options.txtAreaObj.focus();
                            setCursorPosition(tc, cpos);//设置焦点
                            document.selection.createRange().text = faceText;
                            //计算光标位置
                            pos = getPositionForTextArea(tc); 
                        } else {//火狐
                            //计算光标位置
                            pos = tc.selectionStart + faceText.length;
                            options.txtAreaObj.val(options.txtAreaObj.val().substr(0, tc.selectionStart) + faceText + options.txtAreaObj.val().substring(tc.selectionStart, tclen));
                        }
                        cpos = pos;
                        setCursorPosition(tc, pos);//设置焦点
                        container.find("#face").remove();

                    });
                    //关闭表情框
                    container.find(".f_close").bind("click", function() {
                        container.find("#face").remove();
                    });
                    //处理js事件冒泡问题
                    $('body').bind("click", function(e) {
                        e.stopPropagation();
                        container.find('#face').remove();
                        $(this).unbind('click');
                    });
                    if(options.popName != '') {
                        $(window.frames[options.popName].document).find('body').bind("click", function(e) {
                            e.stopPropagation();
                            container.find('#face').remove();
                        });
                    }
                    container.find('#face').bind("click", function(e) {
                        e.stopPropagation();
                    });
                    var offset = $(e.target).offset();
                    offset.top += options.top;
                    offset.left += options.left;
                    container.find("#face").css(offset).show();
                });
            });
        },
        //表情文字符号转换为html格式
        emotionsToHtml : function(options) {
            return this.each(function() {
                var msgObj = $(this);
                var rContent = msgObj.html();
				//alert(rContent);
				//return 0;
                var regx = /(\[[\u4e00-\u9fa5]*\w*\]){1}/g;
                //正则查找“[]”格式
                var rs = rContent.match(regx);
                if(rs) {
                    for( i = 0; i < rs.length; i++) {
                        for( n = 0; n < em.length; n++) {
                            if(em[n].phrase == rs[i]) {
                                var t = "<img src='static/images/emotions/"  + em[n].url + "' />";
                                rContent = rContent.replace(rs[i], t);
                                break;
                            }
                        }
                    }
                }
                msgObj.html(rContent);
            });
        }
    })
})(jQuery);
