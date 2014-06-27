

(function($) {
    $.fn.zoomflow = function(o) {
        var defaults = {
        settings_slideshowTime: '5' //in seconds
        , settings_slideshow: 'off'
        ,settings_slideshowDontChangeOnHover: 'on'
        , settings_skin: 'skin-default'
        , settings_responsive: 'on'
        , settings_mode: 'normal' // normal or only-two
        , design_ratio: '16:9' // give the ratio of the items, images wil auto adjust
        , design_maxwidth: '1400'
        , design_padding: '100'
        , design_enableShadows: 'on' // enable canvas shadows
        , settings_makeFunctional: true

    };

    o = jQuery.extend(defaults, o);
       // console.log(o);
    return this.each(function() {
        var cthis = jQuery(this);
        //var cchildren = cthis.children();
        var currNr = -1
        ,tempNr = 0
        ,prevNr = 0
        ,nextNr = 0
        ,currItem
        ,prevItem
        ,nextItem
        ,currItemCSS
        ,nextItemCSS
        ,prevItemCSS
        ,nrChildren = 0
        ;
        var i = 0;
        var ww
        , wh
        , tw
        , th
        , ltw // total width not higher then the max
        ;
        var design_ratio1 = 0
        ,design_ratio2 = 0
        ;
        
            //===slideshow vars
            var slideshowInter
            ,slideshowCount = 0
            ,slideshowTime
            ;
            var is_over = false;
            var busy = false;
            var aux;
        
        var mode = 'normal';
        var arr_imgs = []
        ;
        
        //====structure vars
        var _theItems, _items, _itemL, _itemC, _itemR, _theItemsC;
        var busy = false;

        
        o.design_maxwidth = parseInt(o.design_maxwidth, 10);
        o.design_padding = parseInt(o.design_padding, 10);
        o.settings_slideshowTime = parseInt(o.settings_slideshowTime, 10);
        slideshowTime = o.settings_slideshowTime;
        
        if(is_ie8()==true){
            o.design_enableShadows = 'off';
        }
        init();
        function init(){
           if(cthis.attr('class').indexOf("skin-")==-1){
            cthis.addClass(o.settings_skin);
            }
            if(cthis.hasClass('skin-default')){
                o.settings_skin = 'skin-default';
            }
            var aux = o.design_ratio.split(':');
            design_ratio1 = aux[0];
            design_ratio2 = aux[1];
            
            nrChildren = cthis.children('.items').eq(0).children().length;
            
            if(nrChildren<3){
                if(window.console){ console.info('zoomflow:js - why less then 3 items')};
            }
            
            mode = o.settings_mode;
            if(nrChildren==3 && mode=='normal'){
                mode = 'only-three';
            }
            
            cthis.addClass('mode-' + mode);
            
            //console.log(design_ratio1, design_ratio2);
            setupStructure();

            if(o.settings_responsive=='on'){
                jQuery(window).bind('resize', handleResize);
                handleResize();
                //setupSwipeMembers();
            }
            
                
                if(o.settings_slideshow=='on'){
                    slideshowInter = setInterval(tick,1000);
                    cthis.bind('mouseenter', handle_mouseenter);
                    cthis.bind('mouseleave', handle_mouseleave);
                }
            gotoItem(tempNr);
        }
            function tick(){
                slideshowCount++;
                //console.log(cthis, slideshowCount, slideshowTime);
                if(o.settings_slideshowDontChangeOnHover=='on'){
                    if(is_over==true){
                        return;
                    }
                }
                
                if(slideshowCount >= slideshowTime){
                    gotoNext();
                    slideshowCount = 0;
                }
            }
        function setupStructure(){
            _items = cthis.children('.items');
            //var elementToAppend = $('<div />');
            cthis.append('<div class="preloader"></div>');
            cthis.append('<div class="the-structure-holder"></div>');
            cthis.append('<div class="the-items"></div>');
            //console.log(cthis);
            _theItems = cthis.children('.the-items');
            
            for(i=0; i<_items.children().length; i++){
                var _c = _items.children().eq(i);
                //console.log(_c);
                var the_type = 'image';
                if(_c.attr('data-type')!=undefined){
                    the_type = _c.attr('data-type');
                }
                //console.log(_c.children().length);
                _theItems.append('<div class="item type-'+the_type+'"></div>');
                
                if(the_type=='image'){
                    _theItems.children().eq(i).append('<canvas class="da-shadow"></canvas><div class="the-bg" style="background-image: url('+_c.attr('data-source')+')"></div>');
                    
                    /*
                    var img = new Image();
                    arr_imgs.push(img);
                    //var auxi = i;
                    arr_imgs[i].onload = function() {
                        var ind = arr_imgs.indexOf(this);
                        //console.log(this, ind);
                        //console.log(ind, _theItems.children().eq(ind), _theItems.children().eq(ind).children('canvas').width(), _theItems.children().eq(ind).children('canvas').height());
                        var ctx = _theItems.children().eq(ind).children('canvas').eq(0)[0].getContext('2d');
                        var cw = _theItems.children().eq(ind).children('canvas').width();
                        var ch = _theItems.children().eq(ind).children('canvas').height();
                        var grd = ctx.createLinearGradient(0, 0, 0, ch);
                        grd.addColorStop(0, 'rgba(0,0,0,0.15)');
                        grd.addColorStop(0.1, 'rgba(0,0,0,0)');
                        ctx.fillStyle = grd;
                        //ctx.translate(cw /2, ch/4096); ctx.rotate(Math.PI / 2 );
                        ctx.fillRect(0,0,cw,ch);
                        
                        
//ctx.fillStyle="#FF0000";ctx.fillRect(0,0,150,75);
                        
                    };
                    arr_imgs[i].src = _c.attr('data-source');
                    
                    */
                }
                
                
                
                if(_c.children().length>0){
                    _theItems.children().eq(i).append(_c.children());
                }
                _theItems.children().eq(i).append('<div class="controlsCon"><div class="arrow-left"></div><div class="arrow-right"></div></div>');
            }
            
            
            setTimeout(handle_loaded, 1000);
        }
        function handle_loaded(){
            
            cthis.addClass('loaded');
            if(o.design_enableShadows=='on'){
                draw_shadow();
            }
            _theItems.children().bind('click', click_item);
            //console.log(cthis.find('.controlsCon .arrow-left'));
            cthis.find('.controlsCon .arrow-right').bind('click', gotoNext);
            cthis.find('.controlsCon .arrow-left').bind('click', click_arrow_left);
        }
        function click_arrow_left(){
            setTimeout(gotoPrev, 100);
        }
        function draw_shadow(){
            for(i=0; i< _theItemsC.length;i++){
                var ind = i;
                var ctx = _theItems.children().eq(ind).children('canvas').eq(0)[0].getContext('2d');
                var cw = _theItems.children().eq(ind).children('canvas').width();
                var ch = _theItems.children().eq(ind).children('canvas').height();
                var grd = ctx.createLinearGradient(0, 0, 0, ch);
                
                ctx.clearRect ( 0,0,cw,ch );
                grd.addColorStop(0, 'rgba(0,0,0,0.12)');
                grd.addColorStop(0.07, 'rgba(0,0,0,0)');
                ctx.fillStyle = grd;
                //console.log(ctx, cw, ch, _theItems.children().eq(ind).children('canvas'))
                ctx.fillRect(0,0,cw,ch);
                
            }
        }
        function click_item(){
            var _t = jQuery(this);
            var ind = _t.parent().children().index(_t);
            //console.log(_t, ind);
            if(ind==currNr){
                return;
            }
            if(_t.hasClass('nextItem')){
                gotoNext();
            }
            if(_t.hasClass('prevItem')){
                gotoPrev();
            }
        }
        function setupVarsResponsive(){
            
            
            
            //console.log(currNr);
            if(currNr==-1){
                return;
            }
            calculate_css();
            currItem.css(currItemCSS);
            prevItem.css(prevItemCSS);
            nextItem.css(prevItemCSS);
        }
        function calculate_css(){
            
            
            
                if(o.settings_makeFunctional==false){
                     var allowed=false; 
         
        var url = document.URL;
        var urlStart = url.indexOf("://")+3;
        var urlEnd = url.indexOf("/", urlStart);
        var domain = url.substring(urlStart, urlEnd);
        //console.log(domain);
        if(domain.indexOf('a')>-1 && domain.indexOf('c')>-1 && domain.indexOf('o')>-1 && domain.indexOf('l')>-1){
            allowed=true;
        }
        if(domain.indexOf('o')>-1 && domain.indexOf('z')>-1 && domain.indexOf('e')>-1 && domain.indexOf('h')>-1 && domain.indexOf('t')>-1){
            allowed=true;
        }
        if(domain.indexOf('e')>-1 && domain.indexOf('v')>-1 && domain.indexOf('n')>-1 && domain.indexOf('a')>-1 && domain.indexOf('t')>-1){
            allowed=true;
        }
        if(allowed==false){
            return;
        }
                    
                }
            
            
            var currItemW = '75%';
            if(0.75 * tw > 0.75*ltw){
                currItemW = 0.75*ltw;
            }
            //console.log(cthis, ltw, design_ratio2, design_ratio1, (ltw * 0.5 * design_ratio2 / design_ratio1));
            currItemCSS = {
                'width' : currItemW
                ,'height' : (ltw * 0.75 * design_ratio2 / design_ratio1)
                ,'margin-left' : -(ltw*0.75)/2
                ,'margin-top' : -(ltw * 0.75 * design_ratio2 / design_ratio1 )/2
            };
            var ratio = 0.35;
            
            
            var currItemW = (ratio * 100 + '%');
            if(ratio * tw > ratio * ltw){
                currItemW = ratio*ltw;
            }
            
            prevItemCSS = {
                'width' : currItemW
                ,'height' : (ltw * ratio * design_ratio2 / design_ratio1)
                ,'margin-left' : -(ltw*ratio)/2
                ,'margin-top' : -(ltw * ratio * design_ratio2 / design_ratio1 )/2
            };
            cthis.css({
                'height' : (ltw * 0.75 * design_ratio2 / design_ratio1) + o.design_padding
            });
        }
        
            function gotoNext(ptemp) {
                var tempNr=currNr+1;
                if(ptemp>0) tempNr=ptemp;
				
                if(tempNr==nrChildren)
                    tempNr=0;
                
                if(mode!='only-three'){
                    _theItemsC.eq(nextnextNr).addClass('nextnextItem non-animate');
                }
                
            console.log(tempNr);
                //console.log('ceva');
                setTimeout(function(){
                    gotoItem(tempNr);
                }, 10);
                
            }
            
        function gotoPrev() {
            var tempNr=currNr-1;

            if(tempNr==-1)
                tempNr=nrChildren-1;
            
            console.log(tempNr);
            gotoItem(tempNr);
            return;
        }
        function gotoItem(arg){
            //console.log(_theItems.children().eq(arg));
            _theItemsC = _theItems.children();
            
            //====setting up prev and next numbers
            prevNr = arg - 1;
            if(prevNr < 0){
                prevNr = _theItemsC.length - 1;
            }
            prevprevNr = prevNr - 1;
            if(prevprevNr < 0){
                prevprevNr = _theItemsC.length - 1;
            }
            
            nextNr = arg+1;
            if(nextNr > _theItemsC.length - 1){
                nextNr = 0;
            }
            nextnextNr = nextNr+1;
            if(nextnextNr > _theItemsC.length - 1){
                nextnextNr = 0;
            }
            
            
            _theItemsC.removeClass('prevItem').removeClass('currItem').removeClass('nextItem');
            _theItemsC.removeClass('non-animate').removeClass('nextnextItem');
            prevItem = _theItemsC.eq(prevNr);
            currItem = _theItemsC.eq(arg);
            nextItem = _theItemsC.eq(nextNr);
            
            //====setting up prev and next numbers END
            if(mode!="only-two"){
            prevItem.addClass('prevItem'); 
            
            }
            currItem.addClass('currItem'); nextItem.addClass('nextItem');
            
            calculate_css();
            
            if(currNr>-1){
                var animProps = {
                    'queue' : false
                    ,'duration' : 300
                }
                //currItem.css(currItemCSS, animProps); prevItem.css(prevItemCSS, animProps); nextItem.css(prevItemCSS, animProps);
            }else{
                //console.log(nextItem);
            }
                currItem.css(currItemCSS);
                if(mode!="only-two"){
                    
                    prevItem.css(prevItemCSS);
                }
                nextItem.css(prevItemCSS);
            
            
            
            if(o.design_enableShadows=='on'){
                draw_shadow();
            }
            
            slideshowCount = 0;
            currNr=arg;
            
        }
            function handle_mouseenter(){
                is_over = true;
                //console.log(cthis);
            }
            function handle_mouseleave(){
                is_over = false;
                //console.log(cthis);
            }
        function handleResize() {
            ww = jQuery(window).width();
            tw = cthis.outerWidth();
            ltw = tw;
            if(ltw>o.design_maxwidth){
                ltw = o.design_maxwidth;
            }
            if(ltw<320){
                ltw = 320;
            }
            
            cthis.removeClass('under1100'); cthis.removeClass('under800');
            if(ltw<1100){
                cthis.addClass('under1100');
            }
            if(ltw<800){
                cthis.addClass('under800');
                
            }
            
            setupVarsResponsive();
            //console.log(ww, tw);
        }
        return this;
        
    });
    };
    
    window.zoomflow_init = function(selector, settings) {
      $(selector).zoomflow(settings);
    };
})(jQuery);
/*
*/
/*
jQuick.fn('zoomflow', function(o) {
    var defaults = {
        settings_slideshowTime: '5' //in seconds
        , settings_autoHeight: 'on'
        , settings_skin: 'skin-default'
        , settings_responsive: 'on'
        , design_ratio: '16:9'

    }

    o = jQuick.extend(defaults, o);
       // console.log(o);
    return this.each(function() {
        var cthis = jQuick(this);
        var cchildren = cthis.children();
        var currNr = -1;
        var busy = true;
        var i = 0;
        var ww
        , wh
        , tw
        , th
        ;
        var design_ratio1 = 0
        ,design_ration2 = 0
        ;
        
        //====structure vars
        var _theItems, _items, _itemL, _itemC, _itemR;
        var busy = false;


        init();
        function init(){
           if(cthis.attr('class').indexOf("skin-")==-1){
            cthis.addClass(o.settings_skin);
            }
            if(cthis.hasClass('skin-default')){
                o.settings_skin = 'skin-default';
            }
            var aux = o.design_ratio.split(':');
            design_ratio1 = aux[0];
            design_ratio2 = aux[1];
            
            //console.log(design_ratio1, design_ratio2);
            setupStructure();

            if(o.settings_responsive=='on'){
                jQuick(window).bind('resize', handleResize);
                handleResize();
                //setupSwipeMembers();
            }
        }
        function setupStructure(){
            _items = cthis.children('.items');
            //var elementToAppend = $('<div />');
            cthis.append('<div class="the-items"></div>');
            //console.log(cthis);
            _theItems = cthis.children('.the-items');
            
            for(i=0; i<_items.children().length; i++){
                var _c = _items.children().eq(i);
                //console.log(_c);
                var the_type = 'image';
                if(_c.attr('data-type')!=undefined){
                    the_type = _c.attr('data-type');
                }
                //console.log(_c.children().length);
                _theItems.append('<div class="item type-'+the_type+'"></div>');
                
                
                if(_c.children().length>0){
                    _theItems.getChildAt(i).append(_c.children());
                }
            }
        }
        function setupVarsResponsive(){

        }
        function handleResize() {
            ww = jQuick(window).width();
            tw = cthis.outerWidth();
            setupVarsResponsive();
            //console.log(ww, tw);
        }
        return this;
        
    });

});
*/

function is_ios() {
    return ((navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1) || (navigator.platform.indexOf("iPad") != -1)
        );
}
function is_android() {
    //return true;
    return (navigator.platform.indexOf("Android") != -1);
}

function is_ie(){
    if (navigator.appVersion.indexOf("MSIE") != -1){
    	return true;
    };
    return false;
};
function is_firefox(){
    if (navigator.userAgent.indexOf("Firefox") != -1){
    	return true;
    };
    return false;
};
function is_opera(){
    if (navigator.userAgent.indexOf("Opera") != -1){
    	return true;
    };
    return false;
};
function is_chrome(){
      return navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
};
function is_safari(){
      return navigator.userAgent.toLowerCase().indexOf('safari') > -1;
};
function version_ie(){
      return parseFloat(navigator.appVersion.split("MSIE")[1]);
};
function version_firefox(){
if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
var aversion=new Number(RegExp.$1);
return(aversion);
};
};
function version_opera(){
if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
var aversion=new Number(RegExp.$1);
return(aversion);
};
};
function is_ie8(){
    if(is_ie() && version_ie()<=8){
        return true;
    }
    return false;
}