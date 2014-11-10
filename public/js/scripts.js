var _debug_ = false;
// display alert message in DEBUG mode only
function _alert_(msg, e) {
    if(_debug_ == true) {
        if(e == undefined) {
            alert(msg);
        } else {
            alert(msg+' '+e.message);
        }
    }
}
//display messages on console in DEBUG mode only
_console_ = {
  log: function (msg) {
        if ( (_debug_ == true) && (typeof console != 'undefined') ) {
            console.log(msg);
        }
    }
};
// highlight menu option
function select_menu_group(group) {
    $('.menu_primary .navigation li').removeClass('group');
    if(group != undefined) {
        $('.menu_primary .navigation li#'+group).addClass('group');
    }
}

String.prototype.format_decimal = function(a,b) {
  var s = this.split('.');
  if (!s[0]) { s[0] = ''; }
  if (!s[1]) { s[1] = ''; }
  s[1] = s[1].substr(0,b);
  while (String(s[0]).length < a) {
    s[0] = '0'+s[0];
    }
  while (String(s[1]).length < b) {
    s[1] = s[1]+'0';
    }
  return s[0]+locale.number.separator.decimal+s[1];
};

// implements pop box message functionality
var ccpopupObj = function(parent) {
this.html ='<div class="ccbox"><div class="vcenter"><div class="content"><span class="b_close_box link" style="float:right;margin-right:10px">'+locale.popup.button.close+'</span>'
          +'<div><div class="head"></div><div class="body"></div><div class="commands"></div></div></div></div></div>';
if (typeof parent != 'string') { parent = 'BODY'; }
this.box = $(this.html).appendTo(parent);
var self = this;
$(this.box).find('.b_close_box').click(function() {
 self.hide();
 });
//alows define custom popup box
this.custom = function(msg, title, buttons, fun, class_name) {
    this.cleanup();
    $(this.box).addClass(class_name);
    var htmlbuttons = '';
    var focus_ctrl_id = null;
    for (var button in buttons) {
        var button_id = 'b_'+button.toLowerCase();
        if (typeof buttons[button] == 'object') {
            var b = buttons[button];
        } else {
            var b = {value:buttons[button]
                    ,'class':''
                    };
        }
        var h = '';
        for (var n in b) {
            if (n.toLowerCase() == 'class') {
                h+=n+'="button '+button_id+' '+b[n]+'" ';
            } else if (n.toLowerCase() == 'focus') {
                if(b[n] == 1 ) focus_ctrl_id = button_id;
            } else {
                h+=n+'="'+b[n]+'" ';
            }
        }
        $(this.box).find('.commands').append('<input type="button" '+h+' />&nbsp;');
        if (typeof fun == 'object') {
            $(this.box).find('.'+button_id).click(eval('fun.on'+button));
        }
    }
    if(focus_ctrl_id != null) $(this.box).find('.'+focus_ctrl_id).focus();
    return this.common(msg,title);
},
// defined popup confirm box with YES/NO buttons
this.confirm = function(msg,title,fun) {
    var self = this;
    return this.custom(msg,title,{'Yes':{'value':locale.popup.button.yes, 'class':'main', 'focus':1},'No':locale.popup.button.no},{
        onYes : function() {
            try {
                fun.onYes();
            } catch(e) {}
            self.hide();
        },
      onNo : function() {
        try {
          fun.onNo();
          } catch(e) {}
        self.hide();
        }
      },'ccbox_confirm');
    },
// message on the top of screen
this.error = function(msg,title) {
    var self = this;
    return this.custom(msg,title,{'Ok':''},{
      onOk: function() {
        self.hide();
        }
      },'ccbox_message ccbox_error');
    };
// message on the top of screen
this.warning = function(msg,title,fun) {
    var self = this;
    return this.custom(msg,title,{'Ok':''},{
        onOk: function() {
            try {
                fun.onOk();
            } catch(e) { }
            self.hide();
        }
      },'ccbox_message ccbox_warning');
    };
// defined popup box with OK button
this.info = function(msg,title,fun) {
    var self = this;
    return this.custom(msg,title,{'Ok':{'value':locale.popup.button.ok, 'class':'main', 'focus':1}},{
        onOk: function() {
            try {
                fun.onOk();
            } catch(e) { }
            self.hide();
        }
      },'ccbox_info');
    };
this.dialog = function(msg,title) {
    this.cleanup();
    $(this.box).addClass('ccbox_dialog');
    return this.common(msg,title);
    };
this.common = function(msg,title) {
    if (typeof title == 'string') { $(this.box).find('.head').html(title); }
    if (typeof msg == 'string') { $(this.box).find('.body').html(msg); }
    return this.show();
    };
this.cleanup = function() {
    $(this.box).attr('class','ccbox');
    return this;
    };
this.show = function() {
    try {
        $(this.box).show();
    } catch(e) {}
    return this;
    };
this.hide = function() {
    try {
        $(this.box).remove();
        delete this;
    } catch(e) {}
//    return this;
    };
this.f_yes = function() {};
this.f_no = function() {};
};

// Gather form data into POST object
function getForm(s) {
  var data = $(s).serializeArray();
  var res = '';
  for (var i in data) {
    res += ",'"+data[i].name.replace('\'','\\\'')+"':'"+data[i].value.replace('\'','\\\'')+"'";
    }
  if (res != '') { res = res.substr(1); } // strip heading comma
  eval('res = {'+res+'}');
  // check for override POST parameter
  var post = $('[post]').each(function() {
    res[$(this).attr('name')] = $(this).attr('post');
  });
  return res;
  }

// simplified send_request
// - by default sends 'GET' request if postdata isn't an object
// - content - may be any valid jquery selector
// - fun   - should return original or modified content received from server
function send_request_new(url, postdata, content, fun) {
  if ((typeof fun != 'object') || (!fun.noBusy)) {
    busy_msg_show();
    }
  var method = 'GET';
  if (typeof postdata == 'object') { method = 'POST'; }
  try {
    $.ajax({
      url:url,
      type:method,
      timeout:60000,
      cache:false,
      global:false,
      data:postdata,
      error:function(data, status, e) {
        busy_msg_hide();
        if ( (typeof fun == 'object') && (typeof fun.onError == 'function') ) {
          fun.onError(data, status);
        }
      },
      success:function(data) {
        try {
          eval('var datao = '+data);
          if ((typeof fun == 'object') && (typeof fun.onCommand == 'function')) {
            try {
              var datao_new = fun.onCommand(datao);
              if (typeof datao_new == 'object') {
                datao = datao_new;
              }
            } catch(e) {}
          }
          switch (datao.cmd) {
            case 'cancel' : busy_msg_hide(); return true;break;
            case 'redirect' : document.location.href = datao.url; return true; break;
            case 'db-error' :busy_msg_hide();
              var ccpopup = new ccpopupObj();
              ccpopup.error(locale.popup.error.internal.msg,locale.popup.error.internal.title);
              return true; break;
            case 'popup' : busy_msg_hide();
                var ccpopup = new ccpopupObj();
                switch(datao.type) {
                    case 'info':    ccpopup.info(datao.msg); break;
                    default:        ccpopup.error(datao.msg); break;
                }
              return true; break;
            case 'no-data' :busy_msg_hide();
              var ccpopup = new ccpopupObj();
              ccpopup.warning(locale.popup.warning.not_found.msg,locale.popup.warning.not_found.title);
              return true; break;
            default:busy_msg_hide();
              var ccpopup = new ccpopupObj();
              ccpopup.error(locale.popup.error.internal.msg,locale.popup.error.internal.title);
              return true; break;
          }
        } catch(e) {
          // alert(e); return true;
        }
        if ((typeof fun == 'object') && (typeof fun.onContentBegin == 'function')) {
          try {
            data = fun.onContentBegin(data);
          } catch(e) {}
        }
        busy_msg_hide();
        if (typeof content == 'string') {
          $(content).html(data);
        }
        if ((typeof fun == 'object') && (typeof fun.onContentEnd == 'function')) {
          try {
            fun.onContentEnd(data);
          } catch(e) {}
        }
      }
    });
    } catch(e) {
      busy_msg_hide();
    }
  }

/* ========================== VALIDATION =================================================================================================*/
// weryfikuje poprawnosc daty
// - date - data do sprawdzenia
// - trim - TRUE wykonaj TRIM przed dalsza analiza (FALSE disabled)
// - req - TRUE pole wymagane (FALSE disabled)
// - min_date - data minimalna (parametr opcjonalny - false lub nie podawać)
function val_date(date, trim, req, min_date) {
    if(trim == true) date = str_trim(date);

    if(req == true) {if(date.length == 0)   return false;}
    else            {if(date.length == 0)   return true;}

    try{
        if(/^([0-9][0-9][0-9][0-9])-(0?[1-9]|1[0-2])-([0-2]?[0-9]|3[0-1])$/.test(date) == false) {
            return false;
        }

        var year = date.substr(0,4);
        var month = date.substr(5,2);
        var day;
        if( (month[1] < '0') || (month[1] > '9')) {
            month = date.substr(5,1);
            day = date.substr(7,2);
            if( (day[1] < '0') || (day[1] > '9'))  day = date.substr(7,1);
        } else {
            day = date.substr(8,2);
            if( (day[1] < '0') || (day[1] > '9'))  day = date.substr(8,1);
        }

        for(i=0; i<year.length; i++)    if( (year[i] < '0') || (year[i] > '9'))  return false;
        for(i=0; i<month.length; i++)   if( (month[i] < '0') || (month[i] > '9'))  return false;
        for(i=0; i<day.length; i++)     if( (day[i] < '0') || (day[i] > '9'))  return false;

        if(is_valid_date(year, month, day) == false)
            return false;

        if(typeof(min_date) != 'undefined'){
            if(val_date(min_date, true, true)){
                if(min_date > date)
                    return false;
            }
        }

    } catch(e) {
        return false;
    }
    return true;
}

// sprawdza czy podany dzien, miesiac i rok tworza poprawna date
// - year   dzien
// - month  miesiac
// - day    rok
function is_valid_date(year, month, day) {
    if (isNaN(year)) return false;
    if (isNaN(month)) return false;
    if (isNaN(day)) return false;

    if (month>12) {return false;}
    if((month==1) ||(month==3) ||(month==5)||(month==7)||(month==8)||(month==10)||(month==12)){
        if(day>31){ return false;}}
    else if((month==4) ||(month==6) ||(month==9)||(month==11)) {
        if(day>30){ return false;}}
    else if ( ( ((year%4) == 0) && ((year%100) !=0) ) || ((year%400) == 0) ) {
        if(day>29) { return false;}}
    else if(day>28) { return false;}
    return true;
}

function is_numeric(value) {
    return (value - 0) == value && value.length > 0;
}

String.prototype.ReplaceAll = function(stringToFind,stringToReplace){
    var temp = this;
    var index = temp.indexOf(stringToFind);
        while(index != -1){
            temp = temp.replace(stringToFind,stringToReplace);
            index = temp.indexOf(stringToFind);
        }
        return temp;
};

// weryfikuje poprawnosc emeila
// - str - text do sprawdzenia
// - trim - TRUE wykonaj TRIM przed dalsza analiza (FALSE disabled)
// - req - TRUE pole wymagane (FALSE disabled)
function val_email(str, trim, req) {
    if(trim == true) str = str_trim(str);

    if(req == true) {if(str.length == 0) return false;}
    else            {if(str.length == 0) return true;}

    //if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/.test(str) == false) return false;
    if (/^([a-zA-Z0-9\+_\-]+)(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/.test(str) == false) return false;

    return true;
}

// funkcja realizuje usuwanie znaku ' ' na poczatku i na koncu stringa
// - str - string do obrobki
function str_trim(str) {
    try {
        str=str.toString();
        return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    } catch(e) {
        return str;
    }
}


/* ========================== CUSTOM =================================================================================================*/
function set_datepicker(elem, param) {
    var allowDelete = false;
    var _format = 'Y-m-d';
    if(param != undefined) {
        if(param['allowDelete'] == true)    allowDelete = true;
        if(param['allowDelete'] == false)   allowDelete = false;
        if(param['format'] != undefined) { _format = param['format']; }
    }
    $(elem).blur(function() {
        try {
            var date = locale.date.fromString($(elem).val());
            $(this).attr('post',locale.date.toString(date,'y-MM-dd'));
        } catch(e) { _alert_(e); }
    });
    $(elem).keydown(function() {
        $(this).DatePickerHide();
    });
    return $(elem).DatePicker({
        format:_format,
        date: $(elem).val(),
        current: $(elem).val(),
        starts: 1,
        allowDelete: allowDelete,
        position: 'bottom',
        hideOnChange: true,
        locale: {
            days: [
                locale.date.dayname[0],locale.date.dayname[1],locale.date.dayname[2],locale.date.dayname[3],
                locale.date.dayname[4],locale.date.dayname[5],locale.date.dayname[6]
            ],
            daysShort: [
                String(locale.date.dayname[0]).substr(0,3),String(locale.date.dayname[1]).substr(0,3),
                String(locale.date.dayname[2]).substr(0,3),String(locale.date.dayname[3]).substr(0,3),
                String(locale.date.dayname[4]).substr(0,3),String(locale.date.dayname[5]).substr(0,3),
                String(locale.date.dayname[6]).substr(0,3)
            ],
            daysMin: [
                String(locale.date.dayname_short[0]),String(locale.date.dayname_short[1]),
                String(locale.date.dayname_short[2]),String(locale.date.dayname_short[3]),
                String(locale.date.dayname_short[4]),String(locale.date.dayname_short[5]),
                String(locale.date.dayname_short[6])
            ],
            months: [
                locale.date.monthname[0],locale.date.monthname[1],locale.date.monthname[2], locale.date.monthname[3],
                locale.date.monthname[4],locale.date.monthname[5],locale.date.monthname[6], locale.date.monthname[7],
                locale.date.monthname[8],locale.date.monthname[9],locale.date.monthname[10],locale.date.monthname[11]
            ],
            monthsShort: [
                String(locale.date.monthname[0]).substr(0,3), String(locale.date.monthname[1]).substr(0,3),
                String(locale.date.monthname[2]).substr(0,3), String(locale.date.monthname[3]).substr(0,3),
                String(locale.date.monthname[4]).substr(0,3), String(locale.date.monthname[5]).substr(0,3),
                String(locale.date.monthname[6]).substr(0,3), String(locale.date.monthname[7]).substr(0,3),
                String(locale.date.monthname[8]).substr(0,3), String(locale.date.monthname[9]).substr(0,3),
                String(locale.date.monthname[10]).substr(0,3),String(locale.date.monthname[11]).substr(0,3)
            ],
            weekMin: locale.date.weekname
        },
        onBeforeShow: function() {
            try {
                var date = $(elem).val();
                date = locale.date.fromString(date);
                if (isNaN(date.getTime())) { date = new Date(); }
                $(elem).DatePickerSetDate(date, true);
                //clear_error_val(elem);
            }catch(e) {}},
        onChange: function(formated, dates){
            $(elem).val(locale.date.toString(dates));
            $(elem).attr('POST',locale.date.toString(dates,'y-MM-dd'));
            $(elem).trigger('change');
            $(elem).DatePickerHide();
            //clear_error_val(elem);
        }});
}

$(function() {
    $(".content_error_con").ajaxError(function(event, request, settings){
        //busy_msg_hide();
    });
    $(".content_error_con").ajaxSuccess(function(evt, request, settings){
        //busy_msg_hide();
    });
});

// --- BUSY
// wyswietla okno komunikatu BUSY
function busy_msg_show() {
    $(function() {
        $('#busy:hidden').show();
    });
}
// ukrywa okno komunikatu BUSY
function busy_msg_hide() {
    $(function() {
        $('#busy').hide();
    });
}

/* ========================== MENU =================================================================================================*/
(function($){
    $.fn.extend({
        //plugin name - animatemenu
        webtoolkitMenu: function(options) {
            return this.each(function() {

                //Assign current element to variable, in this case is UL element
                var obj = $(this);

                $("> li > ul", obj).each(function(i) {
                    $(this).css('top', 19);
                    $("li > a", $(this)).each(function(i) {
                        $(this).click(function() { $("li", obj).removeClass('over dropped'); });
                    });

                    $("li", $(this)).each(function(i) {
                        var item = $(this);
                        if ($("> ul", $(this)).size() > 0) {
                            $("> a", $(this)).append('<span class="submenu">►</span>');
                            $("> label", $(this)).append('<span class="submenu">►</span>');
                        }
                    });
                });

                var droppedItem = null;
                $("> li", obj).hover(
                    function () {
                        var submenu = $(this);
                        submenu.addClass('over');
                        if (droppedItem != null) {
                            droppedItem.clearQueue();
                            droppedItem.removeClass('dropped');
                        }
                        droppedItem = $(this);
                        $(this).clearQueue();
                        $(this).addClass('dropped');
                        $("> ul", submenu).css('top', submenu.outerHeight());
                        if (submenu.hasClass('expand_to_left')) {
                            $("> ul", submenu).each(function(i) {
                                $(this).css('left', submenu.outerWidth() - $(this).outerWidth()); }); }
                    },
                    function () {
                        $(this).removeClass('over');
                        $(this).clearQueue();
                        $(this).delay(600).queue(function(next) {
                            $(this).removeClass('dropped');
                            next();
                        });
                    }
                );

                $("> li ul > li", obj).hover(
                    function () {
                        var submenu = $(this);
                        $(this).addClass('over');
                        $(this).clearQueue();
                        $(this).delay(400).queue(function(next) {
                            $(this).addClass('dropped');
                            $("> ul", submenu).css('top', submenu.position().top);
                            if (submenu.hasClass('expand_to_left')) {
                                $("> ul", submenu).each(function(i) {
                                    $(this).css('left', submenu.position().left - $(this).outerWidth()); });
                            } else {
                                $("> ul", submenu).each(function(i) {
                                    $(this).css('left', submenu.position().left + submenu.outerWidth()); });
                            }
                            next();
                        });
                    },
                    function () {
                        $(this).removeClass('over');
                        $(this).clearQueue();
                        $(this).delay(400).queue(function(next) {
                            $(this).removeClass('dropped');
                            next();
                        });
                    }
                );
            });
        }
    });
})(jQuery);

function menu_click(url,reload) {
  if (reload == true) {
    busy_msg_show();
    document.location.href = url;
  } else {
    var p = {};
    send_request_new(url, p, '#content');
  }
}

/* ============================================== flexigrid.js ================================================================================== */

/*
 * Flexigrid for jQuery - New Wave Grid
 *
 * Copyright (c) 2008 Paulo P. Marinas (webplicity.net/flexigrid)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * $Date: 2008-07-14 00:09:43 +0800 (Tue, 14 Jul 2008) $
 */

(function($){

    $.addFlex = function(t,p)
    {
        if (t.grid) return false; //return if already exist

        // apply default properties
        p = $.extend({
             id: 'flexi',                   // default name
             prefix: '',                    // used to send mode and permision params
             mode: 0,                       // 0-regular; 1-use template
             height: 200,                   //default height
             width: 'auto',                 //auto width
             striped: true,                 //apply odd even stripes
             novstripe: false,
             buttons: false,
             minwidth: 30,                  //min width of columns
             minheight: 80,                 //min height of columns
             resizable: true,               //resizable table
             url: false,                    //ajax url
             method: 'POST',                // data sending method
             dataType: 'json', // type of data loaded - 'xml', 'json'
             errormsg: 'Connection Error',
             nowrap: true,                  //
             title: false,                  // -=1=- -> p.pageNrMsg; -=2=- -> p.pageNrOfMsg

             pagermode: 0,                  // wersja pagera do wyboru
             page: 1,                       //current page
             total: 1,                      //total pages
             usepager: true,                // dispaly paget on the bottom
             nrofpagerboxes: 10,            // number of boxes to change page
             pagestat: 'Displaying {from} to {to} of {total} items',
             bottom_line: '',               // extra html data to place in pager
             useRp: true,                   // allow to change number of rows per page
             rp: 15,                        // number of rows per page
             rpOptions: [10,15,20,25,40],   // number of rows per page combo items
             procmsg: 'Processing, please wait ...',
             pageNrMsg: 'Page',
             pageNrOfMsg: 'of',

             query: '',
             qtype: '',
             nomsg: 'No items',
             minColToggle: 1,                                           //minimum allowed column to be hidden
             showToggleBtn: true,                                       //show or hide column toggle popup
             hideOnSubmit: true,
             autoload: true,                                            // automatyczne ladowanie danych po wygenerowaniu grida
             blockOpacity: 0.5,
             onError: function() {var ccpopup = new ccpopupObj(); ccpopup.error('Internal Error.','Error');},
             onToggleCol: false,
             onChangeSort: false,
             onSuccess: false,
             selectRows: false,
             singleSelect: true,
             showTableToggleBtn: true,
             onSubmit: false,                                           // using a custom populate function
             onStartLoading: function(){busy_msg_show();},              // poczatek czytania danych
             onEndLoading: function(){busy_msg_hide();},                // dane odczytane z serwera
             onDataDisplayed: function(total_nr) {},                    // datane zosatly wyswietlone
             contextMenu: false,
             contextMenuIconPath: '',
             contextMenuTempContent: '#content',                        // pleace where content menu data are stored in dedicated div section
             onContextMenuClick: function(row_id, action, row_data, menuItem, menu) {},
             onSingleItemSelected: function(id, row_data){},            // in single mode send final item state
             onSingleItemUnSelected: function(id, row_data){},          // in single mode send final item state
             onItemSelected: function(id, row_data){},
             onItemClicked: function(id, row_data){},                   // row clicked
             onItemUnSelected: function(id, row_data){},
             preProcess: function(data) {return data;},
             templRow: {
                'row': [
                    '<td>',
                        '<table class="client_grid" cellspacing="0" cellpadding="0"><tbody>',
                            '<tr>',
                                '<td class="pic" rowspan="3"><span><%=cell.pic%></span></td>',
                                '<td class="y_name"><span><%=cell.yacht_name%></span></td>',
                                '<td class="det">',
                                    '<span class="type"><%=cell.yacht_type%></span>',
                                    '<span class="people"><%=cell.bunk%></span>',
                                    '<span class="port"><%=cell.port%></span>',
                                '</td>',
                            '</tr>',
                            '<tr>',
                                '<td class="y_desc" rowspan="2"><span><%=cell.yacht_desc%></span></td>',
                                '<td class="reserv">',
                                    '<span class="period"><%=cell.period%></span>',
                                    '<span class="days">(<%=cell.day_count%>)</span>',
                                    '<span class="price"><%=cell.total_price%></span>',
                                '</td>',
                            '</tr>',
                            '<tr>',
                                '<td class="button" >',
                                    '<img src="images/client/ui_grid_button_view.png" id="button_view" oid="<%=cell.id%>" sdate="<%=cell.start_date%>" edate="<%=cell.end_date%>">',
                                    '<img src="images/client/ui_grid_button_order.png" id="button_order" oid="<%=cell.id%>" sdate="<%=cell.start_date%>" edate="<%=cell.end_date%>">',
                                '</td>',
                            '</tr>',
                        '</tbody></table>',
                    '</td>',
                ]
             },
             templStatusline: {
                0:{'pager':
                        [   '<div class="pGroup"> ',
                                '<div class="pFirst pButton"><span></span></div>',
                                '<div class="pPrev pButton"><span></span></div> ',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup">',
                                '<span class="pcontrol">-=1=- <input type="text" size="4" value="1" /> -=2=- <span> 1 </span></span>',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup pBoxes">',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup"> ',
                                '<div class="pNext pButton"><span></span></div>',
                                '<div class="pLast pButton"><span></span></div> ',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup"> ',
                                '<div class="pReload pButton"><span></span></div> ',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup"><span class="pPageStat"></span></div>'
                        ],
                    'pageBox':
                        [   '<div class="pBox pButton pButtonW"><span><span>-=1=-</span></span></div>'],
                    'pageBoxActive':
                        [   '<div class="pBox pButton pButtonW active"><span><span>-=1=-</span></span></div>']
                },
                1:{'pager':
                        [   '<div class="pGroup"> ',
                                '<div class="pFirst pButton"><span></span></div>',
                                '<div class="pPrev pButton"><span></span></div> ',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup pBoxes">',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup"> ',
                                '<div class="pNext pButton"><span></span></div>',
                                '<div class="pLast pButton"><span></span></div> ',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup"> ',
                                '<div class="pReload pButton"><span></span></div> ',
                            '</div>'],
                    'pageBox':
                        [   '<div class="pBox pButton pButtonW"><span><span>-=1=-</span></span></div>'],
                    'pageBoxActive':
                        [   '<div class="pBox pButton pButtonW active"><span><span>-=1=-</span></span></div>']
                    },
                2:{'pager':
                        [   '<div class="pGroup"> ',
                                '<div class="pFirst pButton"><span></span></div>',
                                '<div class="pPrev pButton"><span></span></div> ',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup">',
                                '<span class="pcontrol">-=1=- <input type="text" size="4" value="1" /> -=2=- <span> 1 </span></span>',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup"> ',
                                '<div class="pNext pButton"><span></span></div>',
                                '<div class="pLast pButton"><span></span></div> ',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup"> ',
                                '<div class="pReload pButton"><span></span></div> ',
                            '</div> ',
                            '<div class="btnseparator"></div> ',
                            '<div class="pGroup"><span class="pPageStat"></span></div>'
                        ],
                    'pageBox':
                        [   '<div class="pBox pButton pButtonW"><span><span>-=1=-</span></span></div>'],
                    'pageBoxActive':
                        [   '<div class="pBox pButton pButtonW active"><span><span>-=1=-</span></span></div>']
                    }
                }

          }, p);


        $(t)
        .show() //show if hidden
        .attr({cellPadding: 0, cellSpacing: 0, border: 0})  //remove padding and spacing
        .removeAttr('width') //remove width properties
        ;

        //create grid class
        var g = {
            hset : {},
            rePosDrag: function () {
                if(p.mode != 0) return;

                var cdleft = 0 - this.hDiv.scrollLeft;
                if (this.hDiv.scrollLeft>0) cdleft -= Math.floor(p.cgwidth/2);
                $(g.cDrag).css({top:g.hDiv.offsetTop+1});
                var cdpad = this.cdpad;

                $('div',g.cDrag).hide();

                $('thead tr:first th:visible',this.hDiv).each ( function () {
                    var n = $('thead tr:first th:visible',g.hDiv).index(this);

                    var cdpos = parseInt($('div',this).width());
                    var ppos = cdpos;
                    if (cdleft==0)
                            cdleft -= Math.floor(p.cgwidth/2);

                    cdpos = cdpos + cdleft + cdpad;

                    $('div:eq('+n+')',g.cDrag).css({'left':cdpos+'px'}).show();

                    cdleft = cdpos;
                });

            },
            fixHeight: function (newH) {
                if(p.mode != 0) return false;

                newH = false;
                if (!newH) newH = $(g.bDiv).height();
                var hdHeight = $(this.hDiv).height();
                $('div',this.cDrag).each(
                    function ()
                        {
                            $(this).height(newH+hdHeight);
                        }
                );

                if(p.mode == 0) {
                    var nd = parseInt($(g.nDiv).height());

                    if (nd>newH)    $(g.nDiv).height(newH).width(200);
                    else            $(g.nDiv).height('auto').width('auto');
                }

                $(g.block).css({height:newH,marginBottom:(newH * -1)});

                var hrH = g.bDiv.offsetTop + newH;
                if (p.height != 'auto' && p.resizable) hrH = g.vDiv.offsetTop;
                $(g.rDiv).css({height: hrH});

            },
            dragStart: function (dragtype,e,obj) { //default drag function start
                if(p.mode != 0) return;

                if (dragtype=='colresize') //column resize
                    {
                        $(g.nDiv).hide();$(g.nBtn).hide();
                        var n = $('div',this.cDrag).index(obj);
                        var ow = $('th:visible div:eq('+n+')',this.hDiv).width();
                        $(obj).addClass('dragging').siblings().hide();
                        $(obj).prev().addClass('dragging').show();

                        this.colresize = {startX: e.pageX, ol: parseInt(obj.style.left), ow: ow, n : n };
                        $('body').css('cursor','col-resize');
                    }
                else if (dragtype=='vresize') //table resize
                    {
                        var hgo = false;
                        $('body').css('cursor','row-resize');
                        if (obj)
                            {
                            hgo = true;
                            $('body').css('cursor','col-resize');
                            }
                        this.vresize = {h: p.height, sy: e.pageY, w: p.width, sx: e.pageX, hgo: hgo};

                    }

                else if (dragtype=='colMove') //column header drag
                    {
                        $(g.nDiv).hide();$(g.nBtn).hide();
                        this.hset = $(this.hDiv).offset();
                        this.hset.right = this.hset.left + $('table',this.hDiv).width();
                        this.hset.bottom = this.hset.top + $('table',this.hDiv).height();
                        this.dcol = obj;
                        this.dcoln = $('th',this.hDiv).index(obj);

                        this.colCopy = document.createElement("div");
                        this.colCopy.className = "colCopy";
                        this.colCopy.innerHTML = obj.innerHTML;
                        if ($.browser.msie)
                        {
                        this.colCopy.className = "colCopy ie";
                        }


                        $(this.colCopy).css({'position':'absolute','float':'left','display':'none', 'textAlign': obj.align});
                        $('body').append(this.colCopy);
                        $(this.cDrag).hide();

                    }

                $('body').noSelect();

            },
            dragMove: function (e) {
                if(p.mode != 0) return;
                if (this.colresize) //column resize
                    {
                        var n = this.colresize.n;
                        var diff = e.pageX-this.colresize.startX;
                        var nleft = this.colresize.ol + diff;
                        var nw = this.colresize.ow + diff;
                        if (nw > p.minwidth)
                            {
                                $('div:eq('+n+')',this.cDrag).css('left',nleft);
                                this.colresize.nw = nw;
                            }
                    }
                else if (this.vresize) //table resize
                    {
                        var v = this.vresize;
                        var y = e.pageY;
                        var diff = y-v.sy;

                        if (!p.defwidth) p.defwidth = p.width;

                        if (p.width != 'auto' && !p.nohresize && v.hgo)
                        {
                            var x = e.pageX;
                            var xdiff = x - v.sx;
                            var newW = v.w + xdiff;
                            if (newW > p.defwidth)
                                {
                                    this.gDiv.style.width = newW + 'px';
                                    p.width = newW;
                                }
                        }

                        var newH = v.h + diff;
                        if ((newH > p.minheight || p.height < p.minheight) && !v.hgo)
                            {
                                this.bDiv.style.height = newH + 'px';
                                p.height = newH;
                                this.fixHeight(newH);
                            }
                        v = null;
                    }
                else if (this.colCopy) {
                    $(this.dcol).addClass('thMove').removeClass('thOver');
                    if (e.pageX > this.hset.right || e.pageX < this.hset.left || e.pageY > this.hset.bottom || e.pageY < this.hset.top)
                    {
                        //this.dragEnd();
                        $('body').css('cursor','move');
                    }
                    else
                    $('body').css('cursor','pointer');
                    $(this.colCopy).css({top:e.pageY + 10,left:e.pageX + 20, display: 'block'});
                }

            },
            dragEnd: function () {
                if(p.mode != 0) return;

                if (this.colresize)
                    {
                        var n = this.colresize.n;
                        var nw = this.colresize.nw;

                                $('th:visible div:eq('+n+')',this.hDiv).css('width',nw);
                                $('tr',this.bDiv).each (
                                    function ()
                                        {
                                        $('td:visible div:eq('+n+')',this).css('width',nw);
                                        }
                                );
                                this.hDiv.scrollLeft = this.bDiv.scrollLeft;


                        $('div:eq('+n+')',this.cDrag).siblings().show();
                        $('.dragging',this.cDrag).removeClass('dragging');
                        this.rePosDrag();
                        this.fixHeight();
                        this.colresize = false;
                    }
                else if (this.vresize)
                    {
                        this.vresize = false;
                    }
                else if (this.colCopy)
                    {
                        $(this.colCopy).remove();
                        if (this.dcolt != null)
                            {


                            if (this.dcoln>this.dcolt)

                                $('th:eq('+this.dcolt+')',this.hDiv).before(this.dcol);
                            else
                                $('th:eq('+this.dcolt+')',this.hDiv).after(this.dcol);



                            this.switchCol(this.dcoln,this.dcolt);
                            $(this.cdropleft).remove();
                            $(this.cdropright).remove();
                            this.rePosDrag();


                            }

                        this.dcol = null;
                        this.hset = null;
                        this.dcoln = null;
                        this.dcolt = null;
                        this.colCopy = null;

                        $('.thMove',this.hDiv).removeClass('thMove');
                        $(this.cDrag).show();
                    }
                $('body').css('cursor','default');
                $('body').noSelect(false);
            },
            toggleCol: function(cid,visible) {
                if(p.mode != 0) return null;

                var ncol = $("th[axis='col"+cid+"']",this.hDiv)[0];
                var n = $('thead th',g.hDiv).index(ncol);
                var cb = $('input[value='+cid+']',g.nDiv)[0];

                if (visible==null) {
                    visible = ncol.hide;
                }

                if ($('input:checked',g.nDiv).length<p.minColToggle&&!visible) return false;

                if (visible) {
                    ncol.hide = false;
                    $(ncol).show();
                    cb.checked = true;
                } else {
                    ncol.hide = true;
                    $(ncol).hide();
                    cb.checked = false;
                }

                $('tbody tr',t).each (
                    function () {
                        if (visible)
                            $('td:eq('+n+')',this).show();
                        else
                            $('td:eq('+n+')',this).hide();
                    }
                );

                this.rePosDrag();

                if (p.onToggleCol) p.onToggleCol(cid,visible);

                return visible;
            },
            switchCol: function(cdrag,cdrop) { //switch columns
                if(p.mode != 0) return;
                $('tbody tr',t).each
                    (
                        function ()
                            {
                                if (cdrag>cdrop)
                                    $('td:eq('+cdrop+')',this).before($('td:eq('+cdrag+')',this));
                                else
                                    $('td:eq('+cdrop+')',this).after($('td:eq('+cdrag+')',this));
                            }
                    );

                    //switch order in nDiv
                    if (cdrag>cdrop)
                        $('tr:eq('+cdrop+')',this.nDiv).before($('tr:eq('+cdrag+')',this.nDiv));
                    else
                        $('tr:eq('+cdrop+')',this.nDiv).after($('tr:eq('+cdrag+')',this.nDiv));

                    if ($.browser.msie&&$.browser.version<7.0) $('tr:eq('+cdrop+') input',this.nDiv)[0].checked = true;

                    this.hDiv.scrollLeft = this.bDiv.scrollLeft;
            },
            scroll: function() {
                    this.hDiv.scrollLeft = this.bDiv.scrollLeft;
                    this.rePosDrag();
            },
            addData: function (data) { //parse data

                try { p.onEndLoading.call(self); } catch (e) {}

                try {
                    var datao;
                    if (p.dataType=='json') {   datao = data; }
                    else                    {   eval('var datao = '+data); }


                    switch (datao.cmd) {
                        case 'cancel' : busy_msg_hide(); return false;break;
                        case 'redirect' : document.location.href = datao.url; return false; break;
                        case 'db-error' :busy_msg_hide();
                            var ccpopup = new ccpopupObj();
                            ccpopup.error('Internal Error.','Error');
                            return false; break;
                        case 'no-data' :busy_msg_hide();
                            var ccpopup = new ccpopupObj();
                            ccpopup.warning("Requested object doesn't exist.",'NO DATA');
                            return false; break;
                        case undefined:
                            break;
                        default:busy_msg_hide();
                            var ccpopup = new ccpopupObj();
                            ccpopup.error('Internal Error.','Error');
                            return false; break;
                    }
                } catch(e) {
                   //alert(e); return false;
                }

                // clear temporary container for menu content rows
                var bind_temp_elem = p.contextMenuTempContent+' .'+p.id+'_temp';
                if($(bind_temp_elem).size()>0) {
                    $(bind_temp_elem).html('');
                }

                if (p.preProcess)
                    data = p.preProcess(data);

                $('.pReload',this.pDiv).removeClass('loading');
                this.loading = false;

                if (!data) {    // no data
                    $('.pPageStat',this.pDiv).html(p.errormsg);
                    return false;
                }

                if (p.dataType=='xml')      p.total = +$('rows total',data).text();
                else                        p.total = data.total;

                if (p.total==0) {   // result empty
                    $('tr, a, td, div',t).unbind();
                    $(t).empty();
                    p.pages = 1;
                    p.page = 1;
                    this.buildpager();
                    $('.pPageStat',this.pDiv).html(p.nomsg);

                    try { p.onDataDisplayed.call(self, p.total); } catch (e) {}

                    return false;
                }

                p.pages = Math.ceil(p.total/p.rp);

                if (p.dataType=='xml')      p.page = +$('rows page',data).text();
                else                        p.page = data.page;

                this.buildpager();

                //build new body
                var tbody = document.createElement('tbody');

                if (p.dataType=='json') {
                    $('tr',t).unbind();
                    $(t).empty();

                    var globThis = this;
                    $.each (
                        data.rows,
                        function(i,row) {
                            var tr = document.createElement('tr');

                            if (i % 2 && p.striped) tr.className = 'erow';

                            if (row.id) tr.id = 'row' + row.id;
                            if(row.style) $(tr).addClass(row.style);

                            //add cell
                            if(p.mode == 0) {
                                $('thead tr:first th',g.hDiv).each (
                                    function () {
                                        var td = document.createElement('td');
                                        var idx = $(this).attr('axis').substr(3);
                                        td.align = this.align;
                                        row_cell_val_i = 0;
                                        for(row_cell_val in row.cell) {
                                            if(row_cell_val_i == idx) { break; }
                                            row_cell_val_i++;
                                        }
                                        td.innerHTML = row.cell[row_cell_val];//row.cell[idx];
                                        $(tr).append(td);
                                        td = null;
                                });

                                if ($('thead',this.gDiv).length<1) { //handle if grid has no headers
                                    for (idx in row.cell) {
                                        var td = document.createElement('td');
                                        td.innerHTML = row.cell[idx];
                                        $(tr).append(td);
                                        td = null;
                                        }
                                }
                            } else {
                                td = g.buildTmpl(p.templRow.row.join(''), row);
                                $(tr).append(td);
                            }

                            $(tbody).append(tr);

                            // add temporary container
                            var bind_temp_elem = p.contextMenuTempContent+' .'+p.id+'_temp';
                            if($(bind_temp_elem).size()==0) {
                                $(p.contextMenuTempContent).append('<div class="'+p.id+'_temp'+'"></div>');
                            }

                            if(p.contextMenu == true) {
                                //alert(row.menu.count())
                                var menu1 = [];
                                $.each(row.menu, function(menu_i, menu_row) {
                                    if(menu_row.name == '---') {
                                        menu1[menu_i] = $.contextMenu.separator;
                                    } else {
                                        menu1[menu_i] = new Array();
                                        menu1[menu_i][menu_row.name] = new Array();
                                        menu1[menu_i][menu_row.name]['onclick'] = function(menuItem,menu) { try { p.onContextMenuClick.call(self, row.id, menu_row.action, row.cell, menuItem, menu); } catch (e) {} } ;
                                        if(!(menu_row.icon === undefined)) {
                                            if(menu_row.disabled == true) {
                                                menu1[menu_i][menu_row.name]['icon'] = p.contextMenuIconPath + menu_row.icon.replace('.', '_.') ;
                                                menu1[menu_i][menu_row.name]['disabled'] = true ;
                                            } else {
                                                menu1[menu_i][menu_row.name]['icon'] = p.contextMenuIconPath + menu_row.icon ;
                                            }
                                        }
                                        if(!(menu_row.className === undefined)) {
                                            menu1[menu_i][menu_row.name]['className'] = menu_row.className;
                                        }
                                        if(!(menu_row.hoverClassName === undefined)) {
                                            menu1[menu_i][menu_row.name]['hoverClassName'] = menu_row.hoverClassName;
                                        }
                                    }
                                });
                                  //{'Option 1':function(menuItem,menu) { try { p.onContextMenuClick.call(self, row.id, menuItem, menu); } catch (e) {} } },
                                  //$.contextMenu.separator,
                                  //{'Option 2':function(menuItem,menu) { alert("You clicked Option 2!"); } }
                                $(function() {
                                    $(tr).contextMenu(menu1, {appendTo: bind_temp_elem});
                                });
                            } else {
                                var menu1 = [];
                                $(function() { $(tr).contextMenu(menu1, {appendTo: bind_temp_elem}); });
                            }

                            globThis.addRowProp($(tr), row.cell);

                            tr = null;
                        }
                    );

                    $(t).append(tbody);

                    if(p.mode == 0) {
                        this.addCellProp();
                        //this.addRowProp();
                    } else {
                        //this.addCellProp();
                        this.addRowProp();
                    }

                } else { // other than xml and json
                    $('tr',t).unbind();
                    $(t).empty();

                    $(t).append(tbody);
                    this.addCellProp();
                    this.addRowProp();
                }

                //this.fixHeight($(this.bDiv).height());

                this.rePosDrag();

                tbody = null; data = null; i = null;

                if (p.onSuccess) p.onSuccess();
                if (p.hideOnSubmit) $(g.block).remove();//$(t).show();

                this.hDiv.scrollLeft = this.bDiv.scrollLeft;
                if ($.browser.opera) $(t).css('visibility','visible');

                try { p.onDataDisplayed.call(self, p.total); } catch (e) {}

            },
            changeSort: function(th) { //change sortorder

                if (this.loading) return true;

                if(p.mode == 0) {
                    $(g.nDiv).hide();$(g.nBtn).hide();
                }

                if (p.sortname == $(th).attr('abbr'))
                    {
                        if (p.sortorder=='asc') p.sortorder = 'desc';
                        else p.sortorder = 'asc';
                    }

                $(th).addClass('sorted').siblings().removeClass('sorted');
                $('.sdesc',this.hDiv).removeClass('sdesc');
                $('.sasc',this.hDiv).removeClass('sasc');
                $('div',th).addClass('s'+p.sortorder);
                p.sortname= $(th).attr('abbr');

                if (p.onChangeSort)
                    p.onChangeSort(p.sortname,p.sortorder);
                else
                    this.populate();

            },
            buildpager: function() { //rebuild pager based on new properties
                $('.pcontrol input',this.pDiv).val(p.page);
                $('.pcontrol span',this.pDiv).html(p.pages);

                var r1 = (p.page-1) * p.rp + 1;
                var r2 = r1 + p.rp - 1;

                if (p.total<r2) r2 = p.total;

                var stat = p.pagestat;

                stat = stat.replace(/{from}/,r1);
                stat = stat.replace(/{to}/,r2);
                stat = stat.replace(/{total}/,p.total);

                $('.pPageStat',this.pDiv).html(stat);

                var boxnr = p.nrofpagerboxes;
                if(p.pages == 0) {
                    $('div.pBoxes',g.pDiv).html("");
                } else if(boxnr > 0) {
                    $('div.pBoxes',g.pDiv).html("");
                    if(boxnr > p.pages) boxnr = p.pages;
                    var boxhtml = p.templStatusline[p.pagermode].pageBox.join('');
                    var boxhtmla = p.templStatusline[p.pagermode].pageBoxActive.join('');

                    if(p.pages == 1) {
                        var boxhtmla_=boxhtmla.replace('-=1=-', '1');
                        $('div.pBoxes',g.pDiv).append(boxhtmla_);
                    } else {
                        var startPage = p.page-Math.floor(boxnr / 2);
                        if(startPage < 1) startPage = 1;
                        var endPage = startPage + boxnr -1;
                        if(endPage > p.pages) {
                            startPage = startPage + (p.pages-endPage);
                        }

                        if(startPage < 1) startPage = 1;
                        if(endPage > p.pages) endPage = p.pages;
                        var bhtml = '';

                        //alert(startPage + ' - ' + endPage);

                        for(i=startPage; i <= endPage; i++) {
                            if(i == p.page) {
                                bhtml = boxhtmla.replace('-=1=-', i);
                                $('div.pBoxes',g.pDiv).append(bhtml);
                            } else {
                                bhtml = boxhtml.replace('-=1=-', i);
                                $('div.pBoxes',g.pDiv).append(bhtml);
                            }
                        }
                    }
                    $('div.pBoxes .pBox span span',g.pDiv).click(function() {
                        g.changePage($(this).html());
                    });
                }

            },
            populate: function () { //get latest data
                if (this.loading) return true;

                if (p.onSubmit) {
                    var gh = p.onSubmit();
                    if (!gh) return false;
                }

                this.loading = true;
                if (!p.url) return false;

                try { p.onStartLoading.call(self); } catch (e) {}

                $('.pPageStat',this.pDiv).html(p.procmsg);

                $('.pReload',this.pDiv).addClass('loading');

                $(g.block).css({top:g.bDiv.offsetTop});

                if (p.hideOnSubmit) $(this.gDiv).prepend(g.block); //$(t).hide();

                if ($.browser.opera) $(t).css('visibility','hidden');

                if (!p.newp) p.newp = 1;

                if (p.page>p.pages) p.page = p.pages;
                //var param = {page:p.newp, rp: p.rp, sortname: p.sortname, sortorder: p.sortorder, query: p.query, qtype: p.qtype};
                var param = [
                     { name : 'page', value : p.newp }
                    ,{ name : 'rp', value : p.rp }
                    ,{ name : 'sortname', value : p.sortname}
                    ,{ name : 'sortorder', value : p.sortorder }
                    ,{ name : 'query', value : p.query}
                    ,{ name : 'qtype', value : p.qtype}
                    ,{ name : 'office', value : $('input#office').val()}
                    ,{ name : 'mode', value : $(p.prefix+' input#mode').val()}
                    ,{ name : 'perm', value : $(p.prefix+' input#perm').val()}
                    ,{ name : 'ajax', value : '1'}
                    ,{ name : 'flex_id', value: p.id}
                ];

                if (p.params) {
                        for (var pi = 0; pi < p.params.length; pi++) param[param.length] = p.params[pi];
                    }

                    $.ajax({
                       type: p.method,
                       url: p.url,
                       data: param,
                       dataType: p.dataType,
                       success: function(data){g.addData(data);},
                       //error: function(data) { try { if (p.onError) p.onError(data); } catch (e) {} }
                       error: function(XMLHttpRequest, textStatus) {
                            try {
                                //if (p.onError) eval(p.onError);
                                try { p.onError.call(self); } catch (e) {}
                                p.onEndLoading.call(self);
                            } catch (e) {}
                        }
                     });
            },
            doSearch: function () {
                p.query = $('input[name=q]',g.sDiv).val();
                p.qtype = $('select[name=qtype]',g.sDiv).val();
                p.newp = 1;

                this.populate();
            },
            changePage: function (ctype) { //change page
                if (this.loading) return true;

                switch(ctype)
                {
                    case 'first': p.newp = 1; break;
                    case 'prev': if (p.page>1) p.newp = parseInt(p.page) - 1; break;
                    case 'next': if (p.page<p.pages) p.newp = parseInt(p.page) + 1; break;
                    case 'last': p.newp = p.pages; break;
                    case 'input':
                            var nv = parseInt($('.pcontrol input',this.pDiv).val());
                            if (isNaN(nv)) nv = 1;
                            if (nv<1) nv = 1;
                            else if (nv > p.pages) nv = p.pages;
                            $('.pcontrol input',this.pDiv).val(nv);
                            p.newp =nv;
                            break;
                    default:
                        if(is_numeric(ctype) == true) {
                            p.newp = ctype;
                        }
                        break;
                }

                if (p.newp==p.page) return false;

                if (p.onChangePage)
                    p.onChangePage(p.newp);
                else
                    this.populate();

            },
            addCellProp: function () {

                    $('tbody tr td',g.bDiv).each
                    (
                        function ()
                            {
                                    var tdDiv = document.createElement('div');
                                    var n = $('td',$(this).parent()).index(this);
                                    var pth = $('th:eq('+n+')',g.hDiv).get(0);

                                    if (pth!=null)
                                    {
                                    if (p.sortname==$(pth).attr('abbr')&&p.sortname)
                                        {
                                        this.className = 'sorted';
                                        }
                                     $(tdDiv).css({textAlign:pth.align,width: $('div:first',pth)[0].style.width});

                                     if (pth.hide) $(this).css('display','none');

                                     }

                                     if (p.nowrap==false) $(tdDiv).css('white-space','normal');

                                     if (this.innerHTML=='') this.innerHTML = '&nbsp;';

                                     //tdDiv.value = this.innerHTML; //store preprocess value
                                     tdDiv.innerHTML = this.innerHTML;

                                     var prnt = $(this).parent()[0];
                                     var pid = false;
                                     if (prnt.id) pid = prnt.id.substr(3);

                                     if (pth!=null)
                                     {
                                     if (pth.process) pth.process(tdDiv,pid);
                                     }

                                    $(this).empty().append(tdDiv).removeAttr('width'); //wrap content

                                    //add editable event here 'dblclick'

                            }
                    );

            },
            getCellDim: function (obj) { // get cell prop for editable event
                var ht = parseInt($(obj).height());
                var pht = parseInt($(obj).parent().height());
                var wt = parseInt(obj.style.width);
                var pwt = parseInt($(obj).parent().width());
                var top = obj.offsetParent.offsetTop;
                var left = obj.offsetParent.offsetLeft;
                var pdl = parseInt($(obj).css('paddingLeft'));
                var pdt = parseInt($(obj).css('paddingTop'));
                return {ht:ht,wt:wt,top:top,left:left,pdl:pdl, pdt:pdt, pht:pht, pwt: pwt};
            },
            addRowProp: function(rows, row_data) {
                    if(rows == null) {
                        rows = $('tbody tr',g.bDiv);
                    }
                    rows.each (
                        function () {
                            $(this)
                            .click (
                                function (e) {
                                    var obj = (e.target || e.srcElement); if (obj.href || obj.type) return true;
                                    try { p.onItemClicked.call(self, $(this).attr('id').substr(3), row_data); } catch (e) {}
                                    if($(this).hasClass('trSelected') == false) {
                                        try { p.onItemSelected.call(self, $(this).attr('id').substr(3), row_data); } catch (e) {}
                                        if (p.singleSelect) {
                                            try { p.onSingleItemSelected.call(self, $(this).attr('id').substr(3), row_data); } catch (e) {}
                                        }
                                    } else {
                                        try { p.onItemUnSelected.call(self, $(this).attr('id').substr(3), row_data); } catch (e) {}
                                        if (p.singleSelect) {
                                            try { p.onSingleItemUnSelected.call(self, $(this).attr('id').substr(3), row_data); } catch (e) {}
                                        }
                                    }
                                    if(p.selectRows == true) {
                                        $(this).toggleClass('trSelected');
                                    } else {
                                        $(this).siblings().removeClass('trSelected');
                                        $(this).removeClass('trSelected');
                                    }

                                    if (p.singleSelect) {
                                        $(this).siblings().each( function() {
                                            if($(this).hasClass('trSelected') == true) {
                                                try { p.onItemUnSelected.call(self, $(this).attr('id').substr(3), row_data); } catch (e) {}
                                            }
                                        });
                                        $(this).siblings().removeClass('trSelected');
                                    }
                                }
                            )
                            .mousedown(
                                function (e) {
                                    if (e.shiftKey) {
                                        if(p.selectRows == true) {
                                            $(this).toggleClass('trSelected');
                                            g.multisel = true;
                                        }
                                        this.focus();
                                        $(g.gDiv).noSelect();
                                    }
                                }
                            )
                            .mouseup(
                                function () {
                                    if (g.multisel) {
                                        g.multisel = false;
                                        $(g.gDiv).noSelect(false);
                                    }
                                }
                            )
                            .hover(
                                function (e) {
                                    if (g.multisel) {
                                        if(p.selectRows == true)  $(this).toggleClass('trSelected');
                                    }
                                },
                                function () {}
                            )
                            ;

                            if ($.browser.msie&&$.browser.version<7.0) {
                                $(this)
                                .hover(
                                    function () { $(this).addClass('trOver'); },
                                    function () { $(this).removeClass('trOver'); }
                                )
                                ;
                            }
                        }
                    );
            },
            buildTmpl: function(str, data) {
                var fn = !/\W/.test(str) ?
                    cache[str] = cache[str] ||
                    tmpl(document.getElementById(str).innerHTML) :
                    new Function("obj",
                                    "var p=[],print=function(){p.push.apply(p,arguments);};" +

                   // Introduce the data as local variables using with(){}
                   "with(obj){p.push('" +

                   // Convert the template into pure JavaScript
                   str
                     .replace(/[\r\t\n]/g, " ")
                     .split("<%").join("\t")
                     .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                     .replace(/\t=(.*?)%>/g, "',$1,'")
                     .split("\t").join("');")
                     .split("%>").join("p.push('")
                     .split("\r").join("\\'")
                 + "');}return p.join('');");

               return data ? fn( data ) : fn;
            },
            pager: 0
            };

        //create model if any
        if (p.colModel)
        {
            thead = document.createElement('thead');
            tr = document.createElement('tr');

            for (i=0;i<p.colModel.length;i++) {
                var cm = p.colModel[i];
                var th = document.createElement('th');

                th.innerHTML = cm.display;

                if (cm.name&&cm.sortable)
                    $(th).attr('abbr',cm.name);

                //th.idx = i;
                $(th).attr('axis','col'+i);

                if (cm.align)
                    th.align = cm.align;

                if (cm.width)
                    $(th).attr('width',cm.width);

                if (cm.hide) {
                    th.hide = true;
                }

                if (cm.process) {
                    th.process = cm.process;
                }

                $(tr).append(th);
            }
            $(thead).append(tr);
            $(t).prepend(thead);
        } // end if p.colmodel

        //init divs
        g.gDiv = document.createElement('div'); //create global container
        g.mDiv = document.createElement('div'); //create title container
        g.hDiv = document.createElement('div'); //create header container
        g.bDiv = document.createElement('div'); //create body container
        g.vDiv = document.createElement('div'); //create grip
        g.rDiv = document.createElement('div'); //create horizontal resizer
        if(p.mode == 0) {
            g.cDrag = document.createElement('div'); //create column drag
        }
        g.block = document.createElement('div'); //creat blocker
        if(p.mode == 0) {
            g.nDiv = document.createElement('div'); //create column show/hide popup
            g.nBtn = document.createElement('div'); //create column show/hide button
        }
        g.iDiv = document.createElement('div'); //create editable layer
        g.tDiv = document.createElement('div'); //create toolbar
        g.sDiv = document.createElement('div');

        if (p.usepager) g.pDiv = document.createElement('div'); //create pager container
        g.hTable = document.createElement('table');

        //set gDiv
        g.gDiv.className = 'flexigrid'+' '+p.id;
        if (p.width!='auto') g.gDiv.style.width = p.width + 'px';

        //add conditional classes
        if ($.browser.msie)
            $(g.gDiv).addClass('ie');

        if (p.novstripe)
            $(g.gDiv).addClass('novstripe');

        $(t).before(g.gDiv);
        $(g.gDiv)
        .append(t)
        ;

        //set toolbar
        if (p.buttons) {
            g.tDiv.className = 'tDiv';
            var tDiv2 = document.createElement('div');
            tDiv2.className = 'tDiv2';

            for (i=0;i<p.buttons.length;i++)
                {
                    var btn = p.buttons[i];
                    if (!btn.separator)
                    {
                        var btnDiv = document.createElement('div');
                        btnDiv.className = 'fbutton';
                        btnDiv.innerHTML = "<div><span>"+btn.name+"</span></div>";
                        if (btn.bclass)
                            $('span',btnDiv)
                            .addClass(btn.bclass)
                            .css({paddingLeft:20})
                            ;
                        btnDiv.onpress = btn.onpress;
                        btnDiv.name = btn.name;
                        if (btn.onpress)
                        {
                            $(btnDiv).click
                            (
                                function ()
                                {
                                this.onpress(this.name,g.gDiv);
                                }
                            );
                        }
                        $(tDiv2).append(btnDiv);
                        if ($.browser.msie&&$.browser.version<7.0)
                        {
                            $(btnDiv).hover(function(){$(this).addClass('fbOver');},function(){$(this).removeClass('fbOver');});
                        }

                    } else {
                        $(tDiv2).append("<div class='btnseparator'></div>");
                    }
                }
                $(g.tDiv).append(tDiv2);
                $(g.tDiv).append("<div style='clear:both'></div>");
                $(g.gDiv).prepend(g.tDiv);
        }

        //set hDiv
        g.hDiv.className = 'hDiv';

        $(t).before(g.hDiv);

        //set hTable
        g.hTable.cellPadding = 0;
        g.hTable.cellSpacing = 0;
        $(g.hDiv).append('<div class="hDivBox"></div>');
        $('div',g.hDiv).append(g.hTable);
        var thead = $("thead:first",t).get(0);
        if (thead) $(g.hTable).append(thead);
        thead = null;

        if (!p.colmodel) var ci = 0;

        //setup thead
        $('thead tr:first th',g.hDiv).each (
            function () {
                var thdiv = document.createElement('div');

                if ($(this).attr('abbr')) {
                    $(this).click( function (e) {
                        if (!$(this).hasClass('thOver')) return false;
                        var obj = (e.target || e.srcElement);
                        if (obj.href || obj.type) return true;
                        g.changeSort(this);
                    }) ;

                    if ($(this).attr('abbr')==p.sortname) {
                        this.className = 'sorted';
                        thdiv.className = 's'+p.sortorder;
                    }
                }

                if (this.hide) $(this).hide();

                if (!p.colmodel) {
                    $(this).attr('axis','col' + ci++);
                }

                $(thdiv).css({textAlign:this.align, width: this.width + 'px'});
                thdiv.innerHTML = this.innerHTML;

                $(this).empty().append(thdiv).removeAttr('width')
                    .mousedown(function (e) {
                        if(p.mode == 0) g.dragStart('colMove',e,this);
                    })
                .hover(
                    function() {
                        if (!g.colresize&&!$(this).hasClass('thMove')&&!g.colCopy) $(this).addClass('thOver');

                        if ($(this).attr('abbr')!=p.sortname&&!g.colCopy&&!g.colresize&&$(this).attr('abbr')) $('div',this).addClass('s'+p.sortorder);
                        else if ($(this).attr('abbr')==p.sortname&&!g.colCopy&&!g.colresize&&$(this).attr('abbr')) {
                            var no = '';
                            if (p.sortorder=='asc') no = 'desc';
                            else no = 'asc';
                            $('div',this).removeClass('s'+p.sortorder).addClass('s'+no);
                        }

                        if (g.colCopy) {
                            var n = $('th',g.hDiv).index(this);

                            if (n==g.dcoln) return false;

                            if (n<g.dcoln) $(this).append(g.cdropleft);
                            else $(this).append(g.cdropright);

                            g.dcolt = n;

                        } else if (!g.colresize) {
                            if(p.mode == 0) {
                                var nv = $('th:visible',g.hDiv).index(this);
                                var onl = parseInt($('div:eq('+nv+')',g.cDrag).css('left'));
                                var nw = parseInt($(g.nBtn).width()) + parseInt($(g.nBtn).css('borderLeftWidth'));
                                if(isNaN(nw) == true) nw = 0;
                                nl = onl - nw + Math.floor(p.cgwidth/2);

                                $(g.nDiv).hide();$(g.nBtn).hide();

                                $(g.nBtn).css({left:nl,top:g.hDiv.offsetTop}).show();

                                var ndw = parseInt($(g.nDiv).width());

                                $(g.nDiv).css({top:g.bDiv.offsetTop});

                                if ((nl+ndw)>$(g.gDiv).width())
                                    $(g.nDiv).css('left',onl-ndw+1);
                                else
                                    $(g.nDiv).css('left',nl);

                                if ($(this).hasClass('sorted'))
                                    $(g.nBtn).addClass('srtd');
                                else
                                    $(g.nBtn).removeClass('srtd');
                            }
                        }
                    },
                    function(){
                        $(this).removeClass('thOver');
                        if ($(this).attr('abbr')!=p.sortname) $('div',this).removeClass('s'+p.sortorder);
                        else if ($(this).attr('abbr')==p.sortname) {
                            var no = '';
                            if (p.sortorder=='asc') no = 'desc';
                            else no = 'asc';

                            $('div',this).addClass('s'+p.sortorder).removeClass('s'+no);
                        }
                        if (g.colCopy) {
                            $(g.cdropleft).remove();
                            $(g.cdropright).remove();
                            g.dcolt = null;
                        }
                    })
                ; //wrap content
            }
        );

        //set bDiv
        g.bDiv.className = 'bDiv';
        $(t).before(g.bDiv);
        $(g.bDiv)
        .css({ height: (p.height=='auto') ? 'auto' : p.height+"px"})
        .scroll(function (e) {g.scroll();})
        .append(t)
        ;

        if (p.height == 'auto') {
            $('table',g.bDiv).addClass('autoht');
        }

        //add td properties
        g.addCellProp();

        //add row properties
        g.addRowProp();

        //set cDrag
        if(p.mode == 0) {
            var cdcol = $('thead tr:first th:first',g.hDiv).get(0);
            if (cdcol != null) {
                g.cDrag.className = 'cDrag';
                g.cdpad = 0;

                g.cdpad += (isNaN(parseInt($('div',cdcol).css('borderLeftWidth'))) ? 0 : parseInt($('div',cdcol).css('borderLeftWidth')));
                g.cdpad += (isNaN(parseInt($('div',cdcol).css('borderRightWidth'))) ? 0 : parseInt($('div',cdcol).css('borderRightWidth')));
                g.cdpad += (isNaN(parseInt($('div',cdcol).css('paddingLeft'))) ? 0 : parseInt($('div',cdcol).css('paddingLeft')));
                g.cdpad += (isNaN(parseInt($('div',cdcol).css('paddingRight'))) ? 0 : parseInt($('div',cdcol).css('paddingRight')));
                g.cdpad += (isNaN(parseInt($(cdcol).css('borderLeftWidth'))) ? 0 : parseInt($(cdcol).css('borderLeftWidth')));
                g.cdpad += (isNaN(parseInt($(cdcol).css('borderRightWidth'))) ? 0 : parseInt($(cdcol).css('borderRightWidth')));
                g.cdpad += (isNaN(parseInt($(cdcol).css('paddingLeft'))) ? 0 : parseInt($(cdcol).css('paddingLeft')));
                g.cdpad += (isNaN(parseInt($(cdcol).css('paddingRight'))) ? 0 : parseInt($(cdcol).css('paddingRight')));

                $(g.bDiv).before(g.cDrag);

                var cdheight = $(g.bDiv).height();
                var hdheight = $(g.hDiv).height();

                $(g.cDrag).css({top: -hdheight + 'px'});

                $('thead tr:first th',g.hDiv).each(
                    function ()
                        {
                            var cgDiv = document.createElement('div');
                            $(g.cDrag).append(cgDiv);
                            if (!p.cgwidth) p.cgwidth = $(cgDiv).width();
                            $(cgDiv).css({height: cdheight + hdheight})
                            .mousedown(function(e){
                                if(p.mode == 0) g.dragStart('colresize',e,this);
                            })
                            ;
                            if ($.browser.msie&&$.browser.version<7.0)
                            {
                                g.fixHeight($(g.gDiv).height());
                                $(cgDiv).hover(
                                    function ()
                                    {
                                    g.fixHeight();
                                    $(this).addClass('dragging');
                                    },
                                    function () { if (!g.colresize) $(this).removeClass('dragging'); }
                                );
                            }
                        }
                );

                //g.rePosDrag();
            }
        }


        //add strip
        if (p.striped)
            $('tbody tr:odd',g.bDiv).addClass('erow');


        if (p.resizable && p.height !='auto') {
            g.vDiv.className = 'vGrip';
            $(g.vDiv)
            .mousedown(function (e) {
                if(p.mode == 0) g.dragStart('vresize',e);
            })
            .html('<span></span>');
            $(g.bDiv).after(g.vDiv);
        }

        if (p.resizable && p.width !='auto' && !p.nohresize) {
            g.rDiv.className = 'hGrip';
            $(g.rDiv)
            .mousedown(function (e) {
                if(p.mode == 0) g.dragStart('vresize',e,true);
            })
            .html('<span></span>')
            .css('height',$(g.gDiv).height())
            ;
            if ($.browser.msie&&$.browser.version<7.0) {
                $(g.rDiv).hover(function(){$(this).addClass('hgOver');},function(){$(this).removeClass('hgOver');});
            }
            $(g.gDiv).append(g.rDiv);
        }

        // add pager
        if (p.usepager) {
            g.pDiv.className = 'pDiv';
            g.pDiv.innerHTML = '<div class="pDiv2 clearfix"></div>';
            $(g.bDiv).after(g.pDiv);

            var html = p.templStatusline[p.pagermode].pager.join('');
            html = html.replace('-=1=-', p.pageNrMsg);
            html = html.replace('-=2=-', p.pageNrOfMsg);
            html = html+p.bottom_line;
            $('div',g.pDiv).html(html);

            $('.pReload',g.pDiv).click(function(){g.populate();});
            $('.pFirst',g.pDiv).click(function(){g.changePage('first');});
            $('.pPrev',g.pDiv).click(function(){g.changePage('prev');});
            $('.pNext',g.pDiv).click(function(){g.changePage('next');});
            $('.pLast',g.pDiv).click(function(){g.changePage('last');});
            $('.pcontrol input',g.pDiv).keydown(function(e){
                if(e.keyCode==13) g.changePage('input');
            });
            if ($.browser.msie&&$.browser.version<7) $('.pButton',g.pDiv).hover(function(){$(this).addClass('pBtnOver');},function(){$(this).removeClass('pBtnOver');});

            $('div.pBoxes',g.pDiv).html('');

            if (p.useRp) {
                var opt = "";
                for (var nx=0; nx<p.rpOptions.length; nx++) {
                    if (p.rp == p.rpOptions[nx]) sel = 'selected="selected"'; else sel = '';
                     opt += "<option value='" + p.rpOptions[nx] + "' " + sel + " >" + p.rpOptions[nx] + "&nbsp;&nbsp;</option>";
                };
                $('.pDiv2',g.pDiv).prepend("<div class='pGroup'><select name='rp'>"+opt+"</select></div> <div class='btnseparator'></div>");
                $('select',g.pDiv).change( function () {
                    if (p.onRpChange) {
                        p.onRpChange(+this.value);
                    } else {
                        p.newp = 1;
                        p.rp = +this.value;
                        g.populate();
                    }
                });
            }

            //add search button
            if (p.searchitems) {
                $('.pDiv2',g.pDiv).prepend("<div class='pGroup'> <div class='pSearch pButton'><span></span></div> </div>  <div class='btnseparator'></div>");
                $('.pSearch',g.pDiv).click(function(){$(g.sDiv).slideToggle('fast',function(){$('.sDiv:visible input:first',g.gDiv).trigger('focus');});});
                //add search box
                g.sDiv.className = 'sDiv';

                sitems = p.searchitems;

                var sopt = "";
                for (var s = 0; s < sitems.length; s++) {
                    if (p.qtype=='' && sitems[s].isdefault==true)
                    {
                    p.qtype = sitems[s].name;
                    sel = 'selected="selected"';
                    } else sel = '';
                    sopt += "<option value='" + sitems[s].name + "' " + sel + " >" + sitems[s].display + "&nbsp;&nbsp;</option>";
                }

                if (p.qtype=='') p.qtype = sitems[0].name;

                $(g.sDiv).append("<div class='sDiv2'>Quick Search <input type='text' size='30' name='q' class='qsbox' /> <select name='qtype'>"+sopt+"</select> <input type='button' value='Clear' /></div>");

                $('input[name=q],select[name=qtype]',g.sDiv).keydown(function(e){if(e.keyCode==13) g.doSearch();});
                $('input[value=Clear]',g.sDiv).click(function(){$('input[name=q]',g.sDiv).val(''); p.query = ''; g.doSearch(); });
                $(g.bDiv).after(g.sDiv);
            }
        }
        $(g.pDiv,g.sDiv).append("<div style='clear:both'></div>");

        // add title
        if (p.title) {
            g.mDiv.className = 'mDiv';
            g.mDiv.innerHTML = '<div class="ftitle">'+p.title+'</div>';
            $(g.gDiv).prepend(g.mDiv);
            if (p.showTableToggleBtn)
                {
                    $(g.mDiv).append('<div class="ptogtitle" title="Minimize/Maximize Table"><span></span></div>');
                    $('div.ptogtitle',g.mDiv).click
                    (
                        function ()
                            {
                                $(g.gDiv).toggleClass('hideBody');
                                $(this).toggleClass('vsble');
                            }
                    );
                }
            //g.rePosDrag();
        }

        //setup cdrops
        g.cdropleft = document.createElement('span');
        g.cdropleft.className = 'cdropleft';
        g.cdropright = document.createElement('span');
        g.cdropright.className = 'cdropright';

        //add block
        g.block.className = 'gBlock';
        var gh = $(g.bDiv).height();
        var gtop = g.bDiv.offsetTop;
        $(g.block).css(
        {
            width: g.bDiv.style.width,
            height: gh,
            background: 'white',
            position: 'relative',
            marginBottom: (gh * -1),
            zIndex: 1,
            top: gtop,
            left: '0px'
        }
        );
        $(g.block).fadeTo(0,p.blockOpacity);

        // add column control
        if(p.mode == 0) {
            if ($('th',g.hDiv).length) {
                g.nDiv.className = 'nDiv';
                g.nDiv.innerHTML = "<table cellpadding='0' cellspacing='0'><tbody></tbody></table>";
                $(g.nDiv).css(
                {
                    marginBottom: (gh * -1),
                    display: 'none',
                    top: gtop
                }
                ).noSelect()
                ;

                var cn = 0;


                $('th div',g.hDiv).each
                (
                    function ()
                        {
                            var kcol = $("th[axis='col" + cn + "']",g.hDiv)[0];
                            var chk = 'checked="checked"';
                            if (kcol.style.display=='none') chk = '';

                            $('tbody',g.nDiv).append('<tr><td class="ndcol1"><input type="checkbox" '+ chk +' class="togCol" value="'+ cn +'" /></td><td class="ndcol2">'+this.innerHTML+'</td></tr>');
                            cn++;
                        }
                );

                if ($.browser.msie&&$.browser.version<7.0)
                    $('tr',g.nDiv).hover
                    (
                        function () {$(this).addClass('ndcolover');},
                        function () {$(this).removeClass('ndcolover');}
                    );

                $('td.ndcol2',g.nDiv).click
                (
                    function ()
                        {
                            if ($('input:checked',g.nDiv).length<=p.minColToggle&&$(this).prev().find('input')[0].checked) return false;
                            return g.toggleCol($(this).prev().find('input').val());
                        }
                );

                $('input.togCol',g.nDiv).click
                (
                    function ()
                        {

                            if ($('input:checked',g.nDiv).length<p.minColToggle&&this.checked==false) return false;
                            $(this).parent().next().trigger('click');
                            //return false;
                        }
                );


                $(g.gDiv).prepend(g.nDiv);

                $(g.nBtn).addClass('nBtn')
                .html('<div></div>')
                .attr('title','Hide/Show Columns')
                .click(
                    function ()
                    {
                    $(g.nDiv).toggle(); return true;
                    }
                );

                if (p.showToggleBtn) $(g.gDiv).prepend(g.nBtn);

            }
        }

        // add date edit layer
        $(g.iDiv)
        .addClass('iDiv')
        .css({display:'none'})
        ;
        $(g.bDiv).append(g.iDiv);

        // add flexigrid events
        $(g.bDiv)
        .hover( function(){
                    if(p.mode == 0) {
                        $(g.nDiv).hide();
                        $(g.nBtn).hide();
                    }
                },
                function(){
                    if (g.multisel) g.multisel = false;
                })
        ;
        $(g.gDiv)
        .hover( function(){},
                function(){
                    if(p.mode == 0) {
                        $(g.nDiv).hide();
                        $(g.nBtn).hide();
                    }
                })
        ;

        //add document events
        if(p.mode == 0) {
            $(document)
            .mousemove(function(e){g.dragMove(e);})
            .mouseup(function(e){g.dragEnd();})
            .hover(function(){},function (){g.dragEnd();})
            ;
        }

        //browser adjustments
        if ($.browser.msie&&$.browser.version<7.0)
        {
            $('.hDiv,.bDiv,.mDiv,.pDiv,.vGrip,.tDiv, .sDiv',g.gDiv)
            .css({width: '100%'});
            $(g.gDiv).addClass('ie6');
            if (p.width!='auto') $(g.gDiv).addClass('ie6fullwidthbug');
        }

        g.rePosDrag();
        g.fixHeight();

        //make grid functions accessible
        t.p = p;
        t.grid = g;

        // load data
        if (p.url&&p.autoload) {
            g.populate();
        }

        return t;

    };

    var docloaded = false;

    $(document).ready(function () {docloaded = true;} );

    $.fn.flexigrid = function(p) {

        return this.each( function() {
                if (!docloaded)
                {
                    $(this).hide();
                    var t = this;
                    $(document).ready
                    (
                        function ()
                        {
                        $.addFlex(t,p);
                        }
                    );
                } else {
                    $.addFlex(this,p);
                }
            });

    }; //end flexigrid

    $.fn.flexReload = function(p) { // function to reload grid

        return this.each( function() {
                if (this.grid&&this.p.url) this.grid.populate();
            });

    }; //end flexReload

    $.fn.flexOptions = function(p) { //function to update general options

        return this.each( function() {
                if (this.grid) $.extend(this.p,p);
            });

    }; //end flexOptions

    $.fn.flexToggleCol = function(cid,visible) { // function to reload grid

        return this.each( function() {
                if (this.grid) this.grid.toggleCol(cid,visible);
            });

    }; //end flexToggleCol

    $.fn.flexAddData = function(data) { // function to add data to grid

        return this.each( function() {
                if (this.grid) this.grid.addData(data);
            });

    };

    $.fn.noSelect = function(p) { //no select plugin by me :-)

        if (p == null)
            prevent = true;
        else
            prevent = p;

        if (prevent) {

        return this.each(function ()
            {
                if ($.browser.msie||$.browser.safari) $(this).bind('selectstart',function(){return false;});
                else if ($.browser.mozilla)
                    {
                        $(this).css('MozUserSelect','none');
                        $('body').trigger('focus');
                    }
                else if ($.browser.opera) $(this).bind('mousedown',function(){return false;});
                else $(this).attr('unselectable','on');
            });

        } else {


        return this.each(function ()
            {
                if ($.browser.msie||$.browser.safari) $(this).unbind('selectstart');
                else if ($.browser.mozilla) $(this).css('MozUserSelect','inherit');
                else if ($.browser.opera) $(this).unbind('mousedown');
                else $(this).removeAttr('unselectable','on');
            });

        }

    }; //end noSelect

})(jQuery);

/* ========================== CALENDAR =================================================================================================*/

/**
*
* Date picker
* Author: Stefan Petre www.eyecon.ro
*
* Dual licensed under the MIT and GPL licenses
*
*/
(function ($) {
    var DatePicker = function () {
        var ids = {},
            views = {
                years: 'datepickerViewYears',
                months: 'datepickerViewMonths',
                days: 'datepickerViewDays'
            },
            tpl = {
                wrapper: {
                    'default': '<div class="datepicker"><div class="datepickerBorderT" /><div class="datepickerBorderB" /><div class="datepickerBorderL" /><div class="datepickerBorderR" /><div class="datepickerBorderTL" /><div class="datepickerBorderTR" /><div class="datepickerBorderBL" /><div class="datepickerBorderBR" /><div class="datepickerContainer"><table cellspacing="0" cellpadding="0"><tbody><tr></tr></tbody></table></div></div>'
                },
                head: {
                    'default':[
                        '<td>',
                        '<table cellspacing="0" cellpadding="0">',
                            '<thead>',
                                '<tr>',
                                    '<th class="datepickerGoPrev"><a href="#"><span><%=prev%></span></a></th>',
                                    '<th colspan="5" class="datepickerMonth"><a href="#"><span></span></a></th>',
                                    '<th class="datepickerGoNext"><a href="#"><span><%=next%></span></a></th>',
                                    '<th class="datepickerDel"><a href="#"><span>&nbsp;</span></a></th>',
                                '</tr>',
                                '<tr class="datepickerDoW">',
                                    '<th><span><%=week%></span></th>',
                                    '<th><span><%=day1%></span></th>',
                                    '<th><span><%=day2%></span></th>',
                                    '<th><span><%=day3%></span></th>',
                                    '<th><span><%=day4%></span></th>',
                                    '<th><span><%=day5%></span></th>',
                                    '<th><span><%=day6%></span></th>',
                                    '<th><span><%=day7%></span></th>',
                                '</tr>',
                            '</thead>',
                        '</table></td>'
                        ]
                },
                space : {
                    'default': '<td class="datepickerSpace"><div></div></td>'
                },
                days: {
                    'default' : [
                        '<tbody class="datepickerDays">',
                            '<tr>',
                                '<th class="datepickerWeek"><a href="#"><span><%=weeks[0].week%></span></a></th>',
                                '<td class="<%=weeks[0].days[0].classname%>"><a href="#"><span class="cal"><%=weeks[0].days[0].text%></span></a></td>',
                                '<td class="<%=weeks[0].days[1].classname%>"><a href="#"><span class="cal"><%=weeks[0].days[1].text%></span></a></td>',
                                '<td class="<%=weeks[0].days[2].classname%>"><a href="#"><span class="cal"><%=weeks[0].days[2].text%></span></a></td>',
                                '<td class="<%=weeks[0].days[3].classname%>"><a href="#"><span class="cal"><%=weeks[0].days[3].text%></span></a></td>',
                                '<td class="<%=weeks[0].days[4].classname%>"><a href="#"><span class="cal"><%=weeks[0].days[4].text%></span></a></td>',
                                '<td class="<%=weeks[0].days[5].classname%>"><a href="#"><span class="cal"><%=weeks[0].days[5].text%></span></a></td>',
                                '<td class="<%=weeks[0].days[6].classname%>"><a href="#"><span class="cal"><%=weeks[0].days[6].text%></span></a></td>',
                            '</tr>',
                            '<tr>',
                                '<th class="datepickerWeek"><a href="#"><span><%=weeks[1].week%></span></a></th>',
                                '<td class="<%=weeks[1].days[0].classname%>"><a href="#"><span class="cal"><%=weeks[1].days[0].text%></span></a></td>',
                                '<td class="<%=weeks[1].days[1].classname%>"><a href="#"><span class="cal"><%=weeks[1].days[1].text%></span></a></td>',
                                '<td class="<%=weeks[1].days[2].classname%>"><a href="#"><span class="cal"><%=weeks[1].days[2].text%></span></a></td>',
                                '<td class="<%=weeks[1].days[3].classname%>"><a href="#"><span class="cal"><%=weeks[1].days[3].text%></span></a></td>',
                                '<td class="<%=weeks[1].days[4].classname%>"><a href="#"><span class="cal"><%=weeks[1].days[4].text%></span></a></td>',
                                '<td class="<%=weeks[1].days[5].classname%>"><a href="#"><span class="cal"><%=weeks[1].days[5].text%></span></a></td>',
                                '<td class="<%=weeks[1].days[6].classname%>"><a href="#"><span class="cal"><%=weeks[1].days[6].text%></span></a></td>',
                            '</tr>',
                            '<tr>',
                                '<th class="datepickerWeek"><a href="#"><span><%=weeks[2].week%></span></a></th>',
                                '<td class="<%=weeks[2].days[0].classname%>"><a href="#"><span class="cal"><%=weeks[2].days[0].text%></span></a></td>',
                                '<td class="<%=weeks[2].days[1].classname%>"><a href="#"><span class="cal"><%=weeks[2].days[1].text%></span></a></td>',
                                '<td class="<%=weeks[2].days[2].classname%>"><a href="#"><span class="cal"><%=weeks[2].days[2].text%></span></a></td>',
                                '<td class="<%=weeks[2].days[3].classname%>"><a href="#"><span class="cal"><%=weeks[2].days[3].text%></span></a></td>',
                                '<td class="<%=weeks[2].days[4].classname%>"><a href="#"><span class="cal"><%=weeks[2].days[4].text%></span></a></td>',
                                '<td class="<%=weeks[2].days[5].classname%>"><a href="#"><span class="cal"><%=weeks[2].days[5].text%></span></a></td>',
                                '<td class="<%=weeks[2].days[6].classname%>"><a href="#"><span class="cal"><%=weeks[2].days[6].text%></span></a></td>',
                            '</tr>',
                            '<tr>',
                                '<th class="datepickerWeek"><a href="#"><span><%=weeks[3].week%></span></a></th>',
                                '<td class="<%=weeks[3].days[0].classname%>"><a href="#"><span class="cal"><%=weeks[3].days[0].text%></span></a></td>',
                                '<td class="<%=weeks[3].days[1].classname%>"><a href="#"><span class="cal"><%=weeks[3].days[1].text%></span></a></td>',
                                '<td class="<%=weeks[3].days[2].classname%>"><a href="#"><span class="cal"><%=weeks[3].days[2].text%></span></a></td>',
                                '<td class="<%=weeks[3].days[3].classname%>"><a href="#"><span class="cal"><%=weeks[3].days[3].text%></span></a></td>',
                                '<td class="<%=weeks[3].days[4].classname%>"><a href="#"><span class="cal"><%=weeks[3].days[4].text%></span></a></td>',
                                '<td class="<%=weeks[3].days[5].classname%>"><a href="#"><span class="cal"><%=weeks[3].days[5].text%></span></a></td>',
                                '<td class="<%=weeks[3].days[6].classname%>"><a href="#"><span class="cal"><%=weeks[3].days[6].text%></span></a></td>',
                            '</tr>',
                            '<tr>',
                                '<th class="datepickerWeek"><a href="#"><span><%=weeks[4].week%></span></a></th>',
                                '<td class="<%=weeks[4].days[0].classname%>"><a href="#"><span class="cal"><%=weeks[4].days[0].text%></span></a></td>',
                                '<td class="<%=weeks[4].days[1].classname%>"><a href="#"><span class="cal"><%=weeks[4].days[1].text%></span></a></td>',
                                '<td class="<%=weeks[4].days[2].classname%>"><a href="#"><span class="cal"><%=weeks[4].days[2].text%></span></a></td>',
                                '<td class="<%=weeks[4].days[3].classname%>"><a href="#"><span class="cal"><%=weeks[4].days[3].text%></span></a></td>',
                                '<td class="<%=weeks[4].days[4].classname%>"><a href="#"><span class="cal"><%=weeks[4].days[4].text%></span></a></td>',
                                '<td class="<%=weeks[4].days[5].classname%>"><a href="#"><span class="cal"><%=weeks[4].days[5].text%></span></a></td>',
                                '<td class="<%=weeks[4].days[6].classname%>"><a href="#"><span class="cal"><%=weeks[4].days[6].text%></span></a></td>',
                            '</tr>',
                            '<tr>',
                                '<th class="datepickerWeek"><a href="#"><span><%=weeks[5].week%></span></a></th>',
                                '<td class="<%=weeks[5].days[0].classname%>"><a href="#"><span class="cal"><%=weeks[5].days[0].text%></span></a></td>',
                                '<td class="<%=weeks[5].days[1].classname%>"><a href="#"><span class="cal"><%=weeks[5].days[1].text%></span></a></td>',
                                '<td class="<%=weeks[5].days[2].classname%>"><a href="#"><span class="cal"><%=weeks[5].days[2].text%></span></a></td>',
                                '<td class="<%=weeks[5].days[3].classname%>"><a href="#"><span class="cal"><%=weeks[5].days[3].text%></span></a></td>',
                                '<td class="<%=weeks[5].days[4].classname%>"><a href="#"><span class="cal"><%=weeks[5].days[4].text%></span></a></td>',
                                '<td class="<%=weeks[5].days[5].classname%>"><a href="#"><span class="cal"><%=weeks[5].days[5].text%></span></a></td>',
                                '<td class="<%=weeks[5].days[6].classname%>"><a href="#"><span class="cal"><%=weeks[5].days[6].text%></span></a></td>',
                            '</tr>',
                        '</tbody>'
                    ]
                },
                months: {
                    'default':[
                        '<tbody class="<%=className%>">',
                            '<tr>',
                                '<td colspan="2"><a href="#"><span><%=data[0]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[1]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[2]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[3]%></span></a></td>',
                            '</tr>',
                            '<tr>',
                                '<td colspan="2"><a href="#"><span><%=data[4]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[5]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[6]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[7]%></span></a></td>',
                            '</tr>',
                            '<tr>',
                                '<td colspan="2"><a href="#"><span><%=data[8]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[9]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[10]%></span></a></td>',
                                '<td colspan="2"><a href="#"><span><%=data[11]%></span></a></td>',
                            '</tr>',
                            '<tr class="last_child">',
                                '<td colspan="8"><a href="#"><span>&nbsp;</span></a></td>',
                            '</tr>',
                        '</tbody>'
                    ]
                }
            },
            defaults = {
                flat: false,
                starts: 1,                      // number of week first day
                prev: '&#171;',
                next: '&#187;',
                lastSel: false,
                mode: 'single',                 // selection type: single, multiple, range, range_multi
                startView: 'days',              // days, months, years
                endView: 'days',                // days, months, years
                calendars: 1,                   // number of calenders displayd in the same time
                //current: '2011-02-24',        // defines start date
                //date: '2011-02-24'            // selection - single date or array with dates - for more see mode
                format: 'Y-m-d',
                position: 'bottom',
                eventName: 'click',
                allowDelete: false,
                notInMothClickable: true,
                onRender: function(){return {};},
                onChange: function(){return true;},
                onChangeRange: function(start, end) {/*alert(start + ' - ' + end);*/},
                hideOnChange: false,
                onShow: function(){return true;},       // return false to prevent show the window
                onBeforeShow: function(){return true;}, // function result is scipped
                onHide: function(){return true;},       // return false to prevent hide the window
                data: { },                              // stores each day custom data used by template
                template_w: 'default',                  // selects tempate version for WRAPPER
                template_h: 'default',                  // selects tempate version for HEAD
                template_s: 'default',                  // selects tempate version for SPACE
                template_d: 'default',                  // selects tempate version for DAYS
                template_m: 'default',                  // selects tempate version for MONTHS
                locale: {
                    //days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                    days: ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela"],
                    //daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    daysShort: ["Nie", "Pon", "Wto", "Śro", "Czw", "Pią", "Sob", "Nie"],
                    //daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
                    daysMin: ["Ni", "Po", "Wt", "Sr", "Cz", "Pi", "So", "Ni"],
                    //months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    months: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"],
                    //monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    monthsShort: ["Sty", "Luty", "Mar", "Kwi", "Maj", "Cze", "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru"],
                    //weekMin: 'wk'
                    weekMin: 'Ty'
                }
            },
            fill = function(el) {
                var options = $(el).data('datepicker');
                var cal = $(el);
                var currentCal = Math.floor(options.calendars/2), date, data, dow, month, cnt = 0, week, days, indic, indic2, html, tblCal;

                var dow;
                dateS = new Date(options.current);
                dateS.addMonths(-currentCal + 0);
                dateE = new Date(options.current);
                dateE.addMonths(-currentCal + (options.calendars-1));

                // first calendar start date (date visible on view)
                var dateSs = new Date(dateS);
                var dow = (dateSs.getDay() - options.starts) % 7;
                dateSs.addDays(-(dow + (dow < 0 ? 7 : 0)));
                // first calendar end date (date visible on view)
                var dateSe = new Date(dateSs);
                dateSe.addDays(41);

                // last calendar start date (date visible on view)
                var dateEs = new Date(dateE);
                var dow = (dateEs.getDay() - options.starts) % 7;
                dateEs.addDays(-(dow + (dow < 0 ? 7 : 0)));
                // last calendar end date (date visible on view)
                var dateEe = new Date(dateEs);
                dateEe.addDays(41);

                //alert('Przedzial '+dateSs+'--'+dateSe + ' Przedzial '+dateEs+'--'+dateEe+ ' Finalnie '+dateSs+'--'+dateEe);

                options.onChangeRange.apply(this, [dateSs, dateEe]);

                cal.find('td>table tbody').remove();
                for (var i = 0; i < options.calendars; i++) { // iterate for each calendar
                    date = new Date(options.current);
                    date.addMonths(-currentCal + i);
                    tblCal = cal.find('table').eq(i+1);

                    switch (tblCal[0].className) {
                        case 'datepickerViewDays':
                            dow = formatDate(date, 'B, Y');
                            break;
                        case 'datepickerViewMonths':
                            dow = date.getFullYear();
                            break;
                        case 'datepickerViewYears':
                            dow = (date.getFullYear()-6) + ' - ' + (date.getFullYear()+5);
                            break;
                    }
                    tblCal.find('thead tr:first th:eq(1) span').text(dow);
                    dow = date.getFullYear()-6;
                    data = {
                        data: [],
                        className: 'datepickerYears'
                    };
                    for ( var j = 0; j < 12; j++) {
                        data.data.push(dow + j);
                    }
                    html = tmpl(tpl.months[options.template_m].join(''), data);
                    date.setDate(1);
                    data = {weeks:[], test: 10};
                    month = date.getMonth();
                    var dow = (date.getDay() - options.starts) % 7;
                    date.addDays(-(dow + (dow < 0 ? 7 : 0)));
                    week = -1;
                    cnt = 0;
                    while (cnt < 42) {
                        indic = parseInt(cnt/7,10);
                        indic2 = cnt%7;
                        if (!data.weeks[indic]) {
                            week = date.getWeekNumber();
                            data.weeks[indic] = {
                                week: week,
                                days: []
                            };
                        }
                        var day_ = date.getDate();  if(day_ < 10) day_ = '0'+day_;
                        var month_ = date.getMonth()+1; if(month_ < 10) month_ = '0'+month_;
                        var date_text = date.getFullYear()+'-'+month_+'-'+day_;
                        var data_price = ''; data_price = '';
                        var data_com = ''; data_com = '';
                        var data_state = ''; data_state = '';
                        if(options.data[date_text] != undefined) {
                            if(options.data[date_text]['price'] != undefined) {
                                data_price = options.data[date_text]['price']; }
                            if(options.data[date_text]['com'] != undefined) {
                                data_com = options.data[date_text]['com']; }
                            if(options.data[date_text]['state'] != undefined) {
                                data_state = options.data[date_text]['state']; }
                            if(options.data[date_text]['ex'] != undefined) {
                                data_state = data_state + ' ' + options.data[date_text]['ex']; }
                        }
                        data.weeks[indic].days[indic2] = {
                            text: date.getDate(),
                            classname: [],
                            price: '',
                            com: '',
                            sclassname: ''
                        };
                        data.weeks[indic].days[indic2]['price'] = data_price;
                        data.weeks[indic].days[indic2]['com'] = data_com;
                        data.weeks[indic].days[indic2]['sclassname'] = data_state;
                        if (month != date.getMonth()) {
                            data.weeks[indic].days[indic2].classname.push('datepickerNotInMonth');
                        }
                        if (date.getDay() == 0) {
                            data.weeks[indic].days[indic2].classname.push('datepickerSunday');
                        }
                        if (date.getDay() == 6) {
                            data.weeks[indic].days[indic2].classname.push('datepickerSaturday');
                        }
                        var fromUser = options.onRender(date);
                        var val = date.valueOf();
                        if (fromUser.selected || options.date == val || $.inArray(val, options.date) > -1 || ((options.mode == 'range' || options.mode == 'range_multi') && val >= options.date[0] && val <= options.date[1])) {
                            data.weeks[indic].days[indic2].classname.push('datepickerSelected');
                        }
                        if (fromUser.disabled) {
                            data.weeks[indic].days[indic2].classname.push('datepickerDisabled');
                        }
                        if (fromUser.className) {
                            data.weeks[indic].days[indic2].classname.push(fromUser.className);
                        }
                        data.weeks[indic].days[indic2].classname = data.weeks[indic].days[indic2].classname.join(' ');
                        cnt++;
                        date.addDays(1);
                    }
                    html = tmpl(tpl.days[options.template_d].join(''), data) + html;
                    data = {
                        data: options.locale.monthsShort,
                        className: 'datepickerMonths'
                    };
                    html = tmpl(tpl.months[options.template_m].join(''), data) + html;
                    tblCal.append(html);
                }
            },
            parseDate = function (date, format) {
                if (date.constructor == Date) {
                    return new Date(date);
                }
                var parts = date.split(/\W+/);
                var against = format.split(/\W+/), d, m, y, h, min, now = new Date();
                for (var i = 0; i < parts.length; i++) {
                    switch (against[i]) {
                        case 'd':
                        case 'e':
                            d = parseInt(parts[i],10);
                            break;
                        case 'm':
                            m = parseInt(parts[i], 10)-1;
                            break;
                        case 'Y':
                        case 'y':
                            y = parseInt(parts[i], 10);
                            y += y > 100 ? 0 : (y < 29 ? 2000 : 1900);
                            break;
                        case 'H':
                        case 'I':
                        case 'k':
                        case 'l':
                            h = parseInt(parts[i], 10);
                            break;
                        case 'P':
                        case 'p':
                            if (/pm/i.test(parts[i]) && h < 12) {
                                h += 12;
                            } else if (/am/i.test(parts[i]) && h >= 12) {
                                h -= 12;
                            }
                            break;
                        case 'M':
                            min = parseInt(parts[i], 10);
                            break;
                    }
                }
                return new Date(
                    y === undefined ? now.getFullYear() : y,
                    m === undefined ? now.getMonth() : m,
                    d === undefined ? now.getDate() : d,
                    h === undefined ? now.getHours() : h,
                    min === undefined ? now.getMinutes() : min,
                    0
                );
            },
            formatDate = function(date, format) {
                var m = date.getMonth();
                var d = date.getDate();
                var y = date.getFullYear();
                var wn = date.getWeekNumber();
                var w = date.getDay();
                var s = {};
                var hr = date.getHours();
                var pm = (hr >= 12);
                var ir = (pm) ? (hr - 12) : hr;
                var dy = date.getDayOfYear();
                if (ir == 0) {
                    ir = 12;
                }
                var min = date.getMinutes();
                var sec = date.getSeconds();
                var parts = format.split(''), part;
                for ( var i = 0; i < parts.length; i++ ) {
                    part = parts[i];
                    switch (parts[i]) {
                        case 'a':
                            part = date.getDayName();
                            break;
                        case 'A':
                            part = date.getDayName(true);
                            break;
                        case 'b':
                            part = date.getMonthName();
                            break;
                        case 'B':
                            part = date.getMonthName(true);
                            break;
                        case 'C':
                            part = 1 + Math.floor(y / 100);
                            break;
                        case 'd':
                            part = (d < 10) ? ("0" + d) : d;
                            break;
                        case 'e':
                            part = d;
                            break;
                        case 'H':
                            part = (hr < 10) ? ("0" + hr) : hr;
                            break;
                        case 'I':
                            part = (ir < 10) ? ("0" + ir) : ir;
                            break;
                        case 'j':
                            part = (dy < 100) ? ((dy < 10) ? ("00" + dy) : ("0" + dy)) : dy;
                            break;
                        case 'k':
                            part = hr;
                            break;
                        case 'l':
                            part = ir;
                            break;
                        case 'm':
                            part = (m < 9) ? ("0" + (1+m)) : (1+m);
                            break;
                        case 'M':
                            part = (min < 10) ? ("0" + min) : min;
                            break;
                        case 'p':
                        case 'P':
                            part = pm ? "PM" : "AM";
                            break;
                        case 's':
                            part = Math.floor(date.getTime() / 1000);
                            break;
                        case 'S':
                            part = (sec < 10) ? ("0" + sec) : sec;
                            break;
                        case 'u':
                            part = w + 1;
                            break;
                        case 'w':
                            part = w;
                            break;
                        case 'y':
                            part = ('' + y).substr(2, 2);
                            break;
                        case 'Y':
                            part = y;
                            break;
                    }
                    parts[i] = part;
                }
                return parts.join('');
            },
            extendDate = function(options) {
                if (Date.prototype.tempDate) {
                    return;
                }
                Date.prototype.tempDate = null;
                Date.prototype.months = options.months;
                Date.prototype.monthsShort = options.monthsShort;
                Date.prototype.days = options.days;
                Date.prototype.daysShort = options.daysShort;
                Date.prototype.getMonthName = function(fullName) {
                    return this[fullName ? 'months' : 'monthsShort'][this.getMonth()];
                };
                Date.prototype.getDayName = function(fullName) {
                    return this[fullName ? 'days' : 'daysShort'][this.getDay()];
                };
                Date.prototype.addDays = function (n) {
                    this.setDate(this.getDate() + n);
                    this.tempDate = this.getDate();
                };
                Date.prototype.addMonths = function (n) {
                    if (this.tempDate == null) {
                        this.tempDate = this.getDate();
                    }
                    this.setDate(1);
                    this.setMonth(this.getMonth() + n);
                    this.setDate(Math.min(this.tempDate, this.getMaxDays()));
                };
                Date.prototype.addYears = function (n) {
                    if (this.tempDate == null) {
                        this.tempDate = this.getDate();
                    }
                    this.setDate(1);
                    this.setFullYear(this.getFullYear() + n);
                    this.setDate(Math.min(this.tempDate, this.getMaxDays()));
                };
                Date.prototype.getMaxDays = function() {
                    var tmpDate = new Date(Date.parse(this)),
                        d = 28, m;
                    m = tmpDate.getMonth();
                    d = 28;
                    while (tmpDate.getMonth() == m) {
                        d ++;
                        tmpDate.setDate(d);
                    }
                    return d - 1;
                };
                Date.prototype.getFirstDay = function() {
                    var tmpDate = new Date(Date.parse(this));
                    tmpDate.setDate(1);
                    return tmpDate.getDay();
                };
                Date.prototype.getWeekNumber = function() {
                    var tempDate = new Date(this);
                    tempDate.setDate(tempDate.getDate() - (tempDate.getDay() + 6) % 7 + 3);
                    var dms = tempDate.valueOf();
                    tempDate.setMonth(0);
                    tempDate.setDate(4);
                    return Math.round((dms - tempDate.valueOf()) / (604800000)) + 1;
                };
                Date.prototype.getDayOfYear = function() {
                    var now = new Date(this.getFullYear(), this.getMonth(), this.getDate(), 0, 0, 0);
                    var then = new Date(this.getFullYear(), 0, 0, 0, 0, 0);
                    var time = now - then;
                    return Math.floor(time / 24*60*60*1000);
                };
            },
            layout = function (el) {
                var options = $(el).data('datepicker');
                var cal = $('#' + options.id);
                if (!options.extraHeight) {
                    var divs = $(el).find('div');
                    options.extraHeight = divs.get(0).offsetHeight + divs.get(1).offsetHeight;
                    options.extraWidth = divs.get(2).offsetWidth + divs.get(3).offsetWidth;
                }
                var tbl = cal.find('table:first').get(0);
                var width = tbl.offsetWidth;
                var height = tbl.offsetHeight;
                cal.css({
                    width: width + options.extraWidth + 'px',
                    height: height + options.extraHeight + 'px'
                }).find('div.datepickerContainer').css({
                    width: width + 'px',
                    height: height + 'px'
                });
            },
            click = function(ev) {
                if ($(ev.target).is('span')) {
                    ev.target = ev.target.parentNode;
                }
                var el = $(ev.target);
                if (el.is('a')) {
                    ev.target.blur();
                    if (el.hasClass('datepickerDisabled')) {
                        return false;
                    }
                    var options = $(this).data('datepicker');
                    var parentEl = el.parent();
                    var tblEl = parentEl.parent().parent().parent();
                    var tblIndex = $('table', this).index(tblEl.get(0)) - 1;
                    var tmp = new Date(options.current);
                    var changed = false;
                    var fillIt = false;
                    if (parentEl.is('th')) {
                        if(parentEl.hasClass('datepickerDel')) {
                            if(options.allowDelete == true) {
                                options.date = '';
                                options.onChange.apply(this, ['', '', options.el]);
                                $('#' + $(this).data('datepicker').id).hide();
                            }
                            return false;
                        } else if (parentEl.hasClass('datepickerWeek') && (options.mode == 'range' || options.mode == 'range_multi') && !parentEl.next().hasClass('datepickerDisabled')) {
                            var val = parseInt(parentEl.next().text(), 10);
                            tmp.addMonths(tblIndex - Math.floor(options.calendars/2));
                            if (parentEl.next().hasClass('datepickerNotInMonth')) {
                                tmp.addMonths(val > 15 ? -1 : 1);
                            }
                            tmp.setDate(val);
                            options.date[0] = (tmp.setHours(0,0,0,0)).valueOf();
                            tmp.setHours(23,59,59,0);
                            tmp.addDays(6);
                            options.date[1] = tmp.valueOf();
                            fillIt = true;
                            changed = true;
                            options.lastSel = false;
                        } else if (parentEl.hasClass('datepickerMonth')) {
                            tmp.addMonths(tblIndex - Math.floor(options.calendars/2));
                            switch (tblEl.get(0).className) {
                                case 'datepickerViewDays':
                                    tblEl.get(0).className = 'datepickerViewMonths';
                                    el.find('span').text(tmp.getFullYear());
                                    break;
                                case 'datepickerViewMonths':
                                    tblEl.get(0).className = 'datepickerViewYears';
                                    el.find('span').text((tmp.getFullYear()-6) + ' - ' + (tmp.getFullYear()+5));
                                    break;
                                case 'datepickerViewYears':
                                    tblEl.get(0).className = 'datepickerViewDays';
                                    el.find('span').text(formatDate(tmp, 'B, Y'));
                                    break;
                            }
                        } else if (parentEl.parent().parent().is('thead')) {
                            switch (tblEl.get(0).className) {
                                case 'datepickerViewDays':
                                    options.current.addMonths(parentEl.hasClass('datepickerGoPrev') ? -1 : 1);
                                    break;
                                case 'datepickerViewMonths':
                                    options.current.addYears(parentEl.hasClass('datepickerGoPrev') ? -1 : 1);
                                    break;
                                case 'datepickerViewYears':
                                    options.current.addYears(parentEl.hasClass('datepickerGoPrev') ? -12 : 12);
                                    break;
                            }
                            fillIt = true;
                        }
                    } else if (parentEl.is('td') && !parentEl.hasClass('datepickerDisabled')) {
                        switch (tblEl.get(0).className) {
                            case 'datepickerViewMonths':
                                options.current.setMonth(tblEl.find('tbody.datepickerMonths td').index(parentEl));
                                options.current.setFullYear(parseInt(tblEl.find('thead th.datepickerMonth span').text(), 10));
                                options.current.addMonths(Math.floor(options.calendars/2) - tblIndex);
                                // day part
                                tmp = new Date(options.current);
                                if(options.endView == 'months') {
                                    switch (options.mode) {
                                        case 'multiple':    break;
                                        case 'range':       break;
                                        case 'range_multi': break;
                                        default: // single
                                            var val = 1;
                                            tmp.addMonths(tblIndex - Math.floor(options.calendars/2));
                                            if (parentEl.hasClass('datepickerNotInMonth')) {
                                                tmp.addMonths(val > 15 ? -1 : 1);
                                            }
                                            tmp.setDate(val);
                                            options.date = tmp.valueOf();
                                    }
                                    changed = true;
                                } else {
                                    tblEl.get(0).className = 'datepickerViewDays';
                                }
                                break;
                            case 'datepickerViewYears':
                                options.current.setFullYear(parseInt(el.text(), 10));
                                // months
                                options.current.setMonth(0);
                                options.current.addMonths(Math.floor(options.calendars/2) - tblIndex);
                                // day part
                                tmp = new Date(options.current);
                                if(options.endView == 'years') {
                                    switch (options.mode) {
                                        case 'multiple':    break;
                                        case 'range':       break;
                                        case 'range_multi': break;
                                        default: // single
                                            var val = 1;
                                            tmp.addMonths(tblIndex - Math.floor(options.calendars/2));
                                            if (parentEl.hasClass('datepickerNotInMonth')) {
                                                tmp.addMonths(val > 15 ? -1 : 1);
                                            }
                                            tmp.setDate(val);
                                            options.date = tmp.valueOf();
                                    }
                                    changed = true;
                                } else {
                                    tblEl.get(0).className = 'datepickerViewMonths';
                                }
                                break;
                            default:
                                var val = parseInt(el.find('.cal').text(), 10);//alert(el.find('.cal').text());
                                tmp.addMonths(tblIndex - Math.floor(options.calendars/2));
                                if (parentEl.hasClass('datepickerNotInMonth')) {
                                    tmp.addMonths(val > 15 ? -1 : 1);
                                    if(options.notInMothClickable == false) return false;
                                }
                                tmp.setDate(val);
                                switch (options.mode) {
                                    case 'multiple':
                                        val = (tmp.setHours(0,0,0,0)).valueOf();
                                        if ($.inArray(val, options.date) > -1) {
                                            $.each(options.date, function(nr, dat){
                                                if (dat == val) {
                                                    options.date.splice(nr,1);
                                                    return false;
                                                }
                                            });
                                        } else {
                                            options.date.push(val);
                                        }
                                        break;
                                    case 'range':
                                        if (!options.lastSel) {
                                            options.date[0] = (tmp.setHours(0,0,0,0)).valueOf();
                                        }
                                        val = (tmp.setHours(23,59,59,0)).valueOf();
                                        if (val < options.date[0]) {
                                            options.date[1] = options.date[0] + 86399000;
                                            options.date[0] = val - 86399000;
                                        } else {
                                            options.date[1] = val;
                                        }
                                        options.lastSel = !options.lastSel;
                                        break;
                                    case 'range_multi':
                                        if (!options.lastSel) {
                                            options.date[0] = (tmp.setHours(0,0,0,0)).valueOf();
                                            options.date[1] = (tmp.setHours(0,0,0,0)).valueOf();
                                        }
                                        val = (tmp.setHours(23,59,59,0)).valueOf();
                                        if (val < options.date[0]) {
                                            options.date[1] = options.date[0] + 86399000;
                                            options.date[0] = val - 86399000;
                                        } else {
                                            options.date[1] = val;
                                        }
                                        options.lastSel = !options.lastSel;
                                        break;
                                    default:
                                        options.date = tmp.valueOf();
                                        break;
                                }
                                changed = true;
                                break;
                        }
                        fillIt = true;
                    }
                    if (fillIt) {
                        fill(this);
                    }
                    if (changed) {
                        options.onChange.apply(this, prepareDate(options));
                        if(options.hideOnChange == true)    $('#' + $(this).data('datepicker').id).hide();
                    }
                }
                return false;
            },
            prepareDate = function (options) {
                var tmp;
                if (options.mode == 'single') {
                    tmp = new Date(options.date);
                    return [formatDate(tmp, options.format), tmp, options.el];
                } else {
                    tmp = [[],[], options.el];
                    $.each(options.date, function(nr, val){
                        var date = new Date(val);
                        tmp[0].push(formatDate(date, options.format));
                        tmp[1].push(date);
                    });
                    return tmp;
                }
            },
            getViewport = function () {
                var m = document.compatMode == 'CSS1Compat';
                return {
                    l : window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
                    t : window.pageYOffset || (m ? document.documentElement.scrollTop : document.body.scrollTop),
                    w : window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth),
                    h : window.innerHeight || (m ? document.documentElement.clientHeight : document.body.clientHeight)
                };
            },
            isChildOf = function(parentEl, el, container) {
                if (parentEl == el) {
                    return true;
                }
                if (parentEl.contains) {
                    return parentEl.contains(el);
                }
                if ( parentEl.compareDocumentPosition ) {
                    return !!(parentEl.compareDocumentPosition(el) & 16);
                }
                var prEl = el.parentNode;
                while(prEl && prEl != container) {
                    if (prEl == parentEl)
                        return true;
                    prEl = prEl.parentNode;
                }
                return false;
            },
            show = function (ev) {
                var cal = $('#' + $(this).data('datepickerId'));
                if (!cal.is(':visible')) {
                    var calEl = cal.get(0);
                    var options = cal.data('datepicker');

                    var tab = cal.find('tr:first').find('table');
                    tab.removeClass(views['years']);
                    tab.removeClass(views['moths']);
                    tab.removeClass(views['days']);
                    tab.addClass(views[options.startView]);

                    fill(calEl);

                    options.onBeforeShow.apply(this, [cal.get(0)]);
                    var pos = $(this).offset();
                    var viewPort = getViewport();
                    var top = pos.top;
                    var left = pos.left;
                    var oldDisplay = $.curCSS(calEl, 'display');
                    cal.css({
                        visibility: 'hidden',
                        display: 'block'
                    });
                    layout(calEl);
                    switch (options.position){
                        case 'top':
                            top -= calEl.offsetHeight;
                            break;
                        case 'left':
                            left -= calEl.offsetWidth;
                            break;
                        case 'right':
                            left += this.offsetWidth;
                            break;
                        case 'bottom':
                            top += this.offsetHeight;
                            break;
                    }
                    if (top + calEl.offsetHeight > viewPort.t + viewPort.h) {
                        top = pos.top  - calEl.offsetHeight;
                    }
                    if (top < viewPort.t) {
                        top = pos.top + this.offsetHeight + calEl.offsetHeight;
                    }
                    if (left + calEl.offsetWidth > viewPort.l + viewPort.w) {
                        left = pos.left - calEl.offsetWidth;
                    }
                    if (left < viewPort.l) {
                        left = pos.left + this.offsetWidth;
                    }
                    cal.css({
                        visibility: 'visible',
                        display: 'block',
                        top: top + 'px',
                        left: left + 'px'
                    });
                    if (options.onShow.apply(this, [cal.get(0)]) != false) {
                        cal.show();
                    }
                    $(document).bind('mousedown', {cal: cal, trigger: this}, hide);
                }
                return false;
            },
            hide = function (ev) {
                if (ev.target != ev.data.trigger && !isChildOf(ev.data.cal.get(0), ev.target, ev.data.cal.get(0))) {
                    if (ev.data.cal.data('datepicker').onHide.apply(this, [ev.data.cal.get(0)]) != false) {
                        ev.data.cal.hide();
                    }
                    $(document).unbind('mousedown', hide);
                }
            };
        return {
            init: function(options) {
                options = $.extend({}, defaults, options||{});
                extendDate(options.locale);
                options.calendars = Math.max(1, parseInt(options.calendars,10)||1);
                options.mode = /single|multiple|range/.test(options.mode) ? options.mode : 'single';
                return this.each(function(){
                    if (!$(this).data('datepicker')) {
                        options.el = this;
                        if (options.date.constructor == String) {
                            options.date = parseDate(options.date, options.format);
                            options.date.setHours(0,0,0,0);
                        }
                        if (options.mode != 'single') {
                            if (options.date.constructor != Array) {
                                options.date = [options.date.valueOf()];
                                if (options.mode == 'range') {
                                    options.date.push(((new Date(options.date[0])).setHours(23,59,59,0)).valueOf());
                                }
                                if (options.mode == 'range_multi') {
                                    options.date.push(((new Date(options.date[0])).setHours(23,59,59,0)).valueOf());
                                }
                            } else {
                                for (var i = 0; i < options.date.length; i++) {
                                    options.date[i] = (parseDate(options.date[i], options.format).setHours(0,0,0,0)).valueOf();
                                }
                                if (options.mode == 'range') {
                                    options.date[1] = ((new Date(options.date[1])).setHours(23,59,59,0)).valueOf();
                                }
                                if (options.mode == 'range_multi') {
                                    options.date[1] = ((new Date(options.date[1])).setHours(23,59,59,0)).valueOf();
                                }
                            }
                        } else {
                            options.date = options.date.valueOf();
                        }
                        if (!options.current) {
                            options.current = new Date();
                        } else {
                            options.current = parseDate(options.current, options.format);
                        }
                        options.current.setDate(1);
                        options.current.setHours(0,0,0,0);
                        var id = 'datepicker_' + parseInt(Math.random() * 1000), cnt;
                        options.id = id;
                        $(this).data('datepickerId', options.id);
                        var cal = $(tpl.wrapper[options.template_w]).attr('id', id).bind('click', click).data('datepicker', options);
                        if (options.className) {
                            cal.addClass(options.className);
                        }
                        var html = '';
                        for (var i = 0; i < options.calendars; i++) {
                            cnt = options.starts;
                            if (i > 0) {
                                html += tpl.space[options.template_s];
                            }
                            html += tmpl(tpl.head[options.template_h].join(''), {
                                    week: options.locale.weekMin,
                                    prev: options.prev,
                                    next: options.next,
                                    day1: options.locale.daysMin[(cnt++)%7],
                                    day2: options.locale.daysMin[(cnt++)%7],
                                    day3: options.locale.daysMin[(cnt++)%7],
                                    day4: options.locale.daysMin[(cnt++)%7],
                                    day5: options.locale.daysMin[(cnt++)%7],
                                    day6: options.locale.daysMin[(cnt++)%7],
                                    day7: options.locale.daysMin[(cnt++)%7]
                                });
                        }
                        cal.find('tr:first').append(html).find('table').addClass(views[options.startView]);
                        if(options.allowDelete == false)    cal.find('.datepickerDel').hide();
                        fill(cal.get(0));
                        if (options.flat) {
                            cal.appendTo(this).show().css('position', 'relative');
                            layout(cal.get(0));
                        } else {
                            cal.appendTo(document.body);
                            $(this).bind(options.eventName, show);
                        }
                    }
                });
            },
            setOptions: function(data) {
                return this.each( function () {
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        options = $.extend({}, options, data||{});
                        cal.data('datepicker', options);
                        fill(cal);
                    }
                });
            },
            getOptions: function() {
                if ($(this).data('datepickerId')) {
                    var cal = $('#' + $(this).data('datepickerId'));
                    var options = cal.data('datepicker');
                    return options;
                }
            },
            showPicker: function() {
                return this.each( function () {
                    if ($(this).data('datepickerId')) {
                        show.apply(this);
                    }
                });
            },
            hidePicker: function() {
                return this.each( function () {
                    if ($(this).data('datepickerId')) {
                        $('#' + $(this).data('datepickerId')).hide();
                    }
                });
            },
            setDate: function(date, shiftTo){
                return this.each(function(){
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        options.date = date;
                        if (options.date.constructor == String) {
                            options.date = parseDate(options.date, options.format);
                            options.date.setHours(0,0,0,0);
                        }
                        if (options.mode != 'single') {
                            if (options.date.constructor != Array) {
                                options.date = [options.date.valueOf()];
                                if (options.mode == 'range') {
                                    options.date.push(((new Date(options.date[0])).setHours(23,59,59,0)).valueOf());
                                }
                                if (options.mode == 'range_multi') {
                                    options.date.push(((new Date(options.date[0])).setHours(23,59,59,0)).valueOf());
                                }
                            } else {
                                for (var i = 0; i < options.date.length; i++) {
                                    options.date[i] = (parseDate(options.date[i], options.format).setHours(0,0,0,0)).valueOf();
                                }
                                if (options.mode == 'range') {
                                    options.date[1] = ((new Date(options.date[1])).setHours(23,59,59,0)).valueOf();
                                }
                                if (options.mode == 'range_multi') {
                                    options.date[1] = ((new Date(options.date[1])).setHours(23,59,59,0)).valueOf();
                                }
                            }
                        } else {
                            options.date = options.date.valueOf();
                        }
                        if (shiftTo) {
                            options.current = new Date (options.mode != 'single' ? options.date[0] : options.date);
                        }
                        fill(cal.get(0));
                    }
                });
            },
            getDate: function(formated) {
                if (this.size() > 0) {
                    return prepareDate($('#' + $(this).data('datepickerId')).data('datepicker'))[formated ? 0 : 1];
                }
            },
            clear: function(){
                return this.each(function(){
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        if (options.mode != 'single') {
                            options.date = [];
                            fill(cal.get(0));
                        }
                    }
                });
            },
            fixLayout: function(){
                return this.each(function(){
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        if (options.flat) {
                            layout(cal.get(0));
                        }
                    }
                });
            }
        };
    }();
    $.fn.extend({
        DatePicker: DatePicker.init,
        DatePickerSetOptions: DatePicker.setOptions,
        DatePickerGetOptions: DatePicker.getOptions,
        DatePickerHide: DatePicker.hidePicker,
        DatePickerShow: DatePicker.showPicker,
        DatePickerSetDate: DatePicker.setDate,
        DatePickerGetDate: DatePicker.getDate,
        DatePickerClear: DatePicker.clear,
        DatePickerLayout: DatePicker.fixLayout
    });
    if (typeof locale == 'undefined') { locale = {}; }
    if (typeof locale.objects == 'undefined') { locale.objects = {}; }
    locale.objects.datepicker = DatePicker;
})(jQuery);

(function(){
 var cache = {};

 this.tmpl = function tmpl(str, data){
   // Figure out if we're getting a template, or if we need to
   // load the template - and be sure to cache the result.
   var fn = !/\W/.test(str) ?
     cache[str] = cache[str] ||
       tmpl(document.getElementById(str).innerHTML) :

     // Generate a reusable function that will serve as a template
     // generator (and which will be cached).
     new Function("obj",
       "var p=[],print=function(){p.push.apply(p,arguments);};" +

       // Introduce the data as local variables using with(){}
       "with(obj){p.push('" +

       // Convert the template into pure JavaScript
       str
         .replace(/[\r\t\n]/g, " ")
         .split("<%").join("\t")
         .replace(/((^|%>)[^\t]*)'/g, "$1\r")
         .replace(/\t=(.*?)%>/g, "',$1,'")
         .split("\t").join("');")
         .split("%>").join("p.push('")
         .split("\r").join("\\'")
     + "');}return p.join('');");

   // Provide some basic currying to the user
   return data ? fn( data ) : fn;
 };
})();

/* ========================== CONTEXT MENU =================================================================================================*/
/**
 * Copyright (c)2005-2009 Matt Kruse (javascripttoolbox.com)
 *
 * Dual licensed under the MIT and GPL licenses.
 * This basically means you can use this code however you want for
 * free, but don't claim to have written it yourself!
 * Donations always accepted: http://www.JavascriptToolbox.com/donate/
 *
 * Please do not link to the .js files on javascripttoolbox.com from
 * your site. Copy the files locally to your server instead.
 *
 */
/**
 * jquery.contextmenu.js
 * jQuery Plugin for Context Menus
 * http://www.JavascriptToolbox.com/lib/contextmenu/
 *
 * Copyright (c) 2008 Matt Kruse (javascripttoolbox.com)
 * Dual licensed under the MIT and GPL licenses.
 *
 * @version 1.1
 * @history 1.1 2010-01-25 Fixed a problem with 1.4 which caused undesired show/hide animations
 * @history 1.0 2008-10-20 Initial Release
 * @todo slideUp doesn't work in IE - because of iframe?
 * @todo Hide all other menus when contextmenu is shown?
 * @todo More themes
 * @todo Nested context menus
 */
;(function($){
    $.contextMenu = {
        shadow:true,
        shadowOffset:0,
        shadowOffsetX:5,
        shadowOffsetY:5,
        shadowWidthAdjust:-3,
        shadowHeightAdjust:-3,
        shadowOpacity:.2,
        shadowClass:'context-menu-shadow',
        shadowColor:'black',

        offsetX:0,
        offsetY:0,
        appendTo:'body',
        direction:'down',
        constrainToScreen:true,

        showTransition:'show',
        hideTransition:'hide',
        showSpeed:null,
        hideSpeed:null,
        showCallback:null,
        hideCallback:null,

        className:'context-menu',
        itemClassName:'context-menu-item',
        itemHoverClassName:'context-menu-item-hover',
        disabledItemClassName:'context-menu-item-disabled',
        disabledItemHoverClassName:'context-menu-item-disabled-hover',
        separatorClassName:'context-menu-separator',
        innerDivClassName:'context-menu-item-inner',
        themePrefix:'context-menu-theme-',
        theme:'default',

        separator:'context-menu-separator', // A specific key to identify a separator
        target:null, // The target of the context click, to be populated when triggered
        menu:null, // The jQuery object containing the HTML object that is the menu itself
        shadowObj:null, // Shadow object
        bgiframe:null, // The iframe object for IE6
        shown:false, // Currently being shown?
        useIframe:/*@cc_on @*//*@if (@_win32) true, @else @*/false,/*@end @*/ // This is a better check than looking at userAgent!

        // Create the menu instance
        create: function(menu,opts) {
            var cmenu = $.extend({},this,opts); // Clone all default properties to created object

            // If a selector has been passed in, then use that as the menu
            if (typeof menu=="string") {
                cmenu.menu = $(menu);
            }
            // If a function has been passed in, call it each time the menu is shown to create the menu
            else if (typeof menu=="function") {
                cmenu.menuFunction = menu;
            }
            // Otherwise parse the Array passed in
            else {
                cmenu.menu = cmenu.createMenu(menu,cmenu);
            }
            if (cmenu.menu) {
                cmenu.menu.css({display:'none'});
                if(menu.length > 0)     $(cmenu.appendTo).append(cmenu.menu);
            }

            // Create the shadow object if shadow is enabled
            if (cmenu.shadow) {
                cmenu.createShadow(cmenu); // Extracted to method for extensibility
                if (cmenu.shadowOffset) { cmenu.shadowOffsetX = cmenu.shadowOffsetY = cmenu.shadowOffset; }
            }
            $('body').bind('contextmenu',function(){cmenu.hide();}); // If right-clicked somewhere else in the document, hide this menu
            return cmenu;
        },

        // Create an iframe object to go behind the menu
        createIframe: function() {
            return $('<iframe frameborder="0" tabindex="-1" src="javascript:false" style="display:block;position:absolute;z-index:-1;filter:Alpha(Opacity=0);"/>');
        },

        // Accept an Array representing a menu structure and turn it into HTML
        createMenu: function(menu,cmenu) {
            var className = cmenu.className;
            $.each(cmenu.theme.split(","),function(i,n){className+=' '+cmenu.themePrefix+n;});
            var $t = $('<table class="context-menu-main" cellspacing=0 cellpadding=0></table>').click(function(){cmenu.hide(); return false;}); // We wrap a table around it so width can be flexible
            var $tr = $('<tr></tr>');
            var $td = $('<td></td>');
            var $div = $('<div class="'+className+'"></div>');

            // Each menu item is specified as either:
            //     title:function
            // or  title: { property:value ... }
            for (var i=0; i<menu.length; i++) {
                var m = menu[i];
                if (m==$.contextMenu.separator) {
                    $div.append(cmenu.createSeparator());
                }
                else {
                    for (var opt in menu[i]) {
                        $div.append(cmenu.createMenuItem(opt,menu[i][opt])); // Extracted to method for extensibility
                    }
                }
            }
            if ( cmenu.useIframe ) {
                $td.append(cmenu.createIframe());
            }
            $t.append($tr.append($td.append($div)));
            return $t;
        },

        // Create an individual menu item
        createMenuItem: function(label,obj) {
            var cmenu = this;
            if (typeof obj=="function") { obj={onclick:obj}; } // If passed a simple function, turn it into a property of an object
            // Default properties, extended in case properties are passed
            var o = $.extend({
                onclick:function() { },
                className:'',
                hoverClassName:cmenu.itemHoverClassName,
                icon:'',
                disabled:false,
                title:'',
                hoverItem:cmenu.hoverItem,
                hoverItemOut:cmenu.hoverItemOut
            },obj);
            // If an icon is specified, hard-code the background-image style. Themes that don't show images should take this into account in their CSS
            var iconStyle = (o.icon)?'background-image:url('+o.icon+');':'';
            var $div = $('<div class="'+cmenu.itemClassName+' '+o.className+((o.disabled)?' '+cmenu.disabledItemClassName:'')+'" title="'+o.title+'"></div>')
                            // If the item is disabled, don't do anything when it is clicked
                            .click(function(e){if(cmenu.isItemDisabled(this)){return false;}else{return o.onclick.call(cmenu.target,this,cmenu,e);}})
                            // Change the class of the item when hovered over
                            .hover( function(){ o.hoverItem.call(this,(cmenu.isItemDisabled(this))?cmenu.disabledItemHoverClassName:o.hoverClassName); }
                                    ,function(){ o.hoverItemOut.call(this,(cmenu.isItemDisabled(this))?cmenu.disabledItemHoverClassName:o.hoverClassName); }
                            );
            var $idiv = $('<div class="'+cmenu.innerDivClassName+'" style="'+iconStyle+'">'+label+'</div>');
            $div.append($idiv);
            return $div;
        },

        // Create a separator row
        createSeparator: function() {
            return $('<div class="'+this.separatorClassName+'"></div>');
        },

        // Determine if an individual item is currently disabled. This is called each time the item is hovered or clicked because the disabled status may change at any time
        isItemDisabled: function(item) { return $(item).is('.'+this.disabledItemClassName); },

        // Functions to fire on hover. Extracted to methods for extensibility
        hoverItem: function(c) { $(this).addClass(c); },
        hoverItemOut: function(c) { $(this).removeClass(c); },

        // Create the shadow object
        createShadow: function(cmenu) {
            cmenu.shadowObj = $('<div class="'+cmenu.shadowClass+'"></div>').css( {display:'none',position:"absolute", zIndex:9998, opacity:cmenu.shadowOpacity, backgroundColor:cmenu.shadowColor } );
            $(cmenu.appendTo).append(cmenu.shadowObj);
        },

        // Display the shadow object, given the position of the menu itself
        showShadow: function(x,y,e) {
            var cmenu = this;
            if (cmenu.shadow) {
                cmenu.shadowObj.css( {
                    width:(cmenu.menu.width()+cmenu.shadowWidthAdjust)+"px",
                    height:(cmenu.menu.height()+cmenu.shadowHeightAdjust)+"px",
                    top:(y+cmenu.shadowOffsetY)+"px",
                    left:(x+cmenu.shadowOffsetX)+"px"
                }).addClass(cmenu.shadowClass)[cmenu.showTransition](cmenu.showSpeed);
            }
        },

        // A hook to call before the menu is shown, in case special processing needs to be done.
        // Return false to cancel the default show operation
        beforeShow: function() { return true; },

        // Show the context menu
        show: function(t,e) {
            $('table.context-menu-main').hide();
            $('div.context-menu-shadow').hide();
            var cmenu=this, x=e.pageX, y=e.pageY;
            cmenu.target = t; // Preserve the object that triggered this context menu so menu item click methods can see it
            if (cmenu.beforeShow()!==false) {
                // If the menu content is a function, call it to populate the menu each time it is displayed
                if (cmenu.menuFunction) {
                    if (cmenu.menu) { $(cmenu.menu).remove(); }
                    cmenu.menu = cmenu.createMenu(cmenu.menuFunction(cmenu,t),cmenu);
                    cmenu.menu.css({display:'none'});
                    $(cmenu.appendTo).append(cmenu.menu);
                }
                var $c = cmenu.menu;
                x+=cmenu.offsetX; y+=cmenu.offsetY;
                var pos = cmenu.getPosition(x,y,cmenu,e); // Extracted to method for extensibility
                cmenu.showShadow(pos.x,pos.y,e);
                // Resize the iframe if needed
                if (cmenu.useIframe) {
                    $c.find('iframe').css({width:$c.width()+cmenu.shadowOffsetX+cmenu.shadowWidthAdjust,height:$c.height()+cmenu.shadowOffsetY+cmenu.shadowHeightAdjust});
                }
                $c.css( {top:pos.y+"px", left:pos.x+"px", position:"absolute",zIndex:9999} )[cmenu.showTransition](cmenu.showSpeed,((cmenu.showCallback)?function(){cmenu.showCallback.call(cmenu);}:null));
                cmenu.shown=true;
                $(document).one('click',null,function(){cmenu.hide();}); // Handle a single click to the document to hide the menu
            }
        },

        // Find the position where the menu should appear, given an x,y of the click event
        getPosition: function(clickX,clickY,cmenu,e) {
            var x = clickX+cmenu.offsetX;
            var y = clickY+cmenu.offsetY;
            var h = $(cmenu.menu).height();
            var w = $(cmenu.menu).width();
            var dir = cmenu.direction;
            if (cmenu.constrainToScreen) {
                var $w = $(window);
                var wh = $w.height();
                var ww = $w.width();
                if (dir=="down" && (y+h-$w.scrollTop() > wh)) { dir = "up"; }
                var maxRight = x+w-$w.scrollLeft();
                if (maxRight > ww) { x -= (maxRight-ww); }
            }
            if (dir=="up") { y -= h; }
            return {'x':x,'y':y};
        },

        // Hide the menu, of course
        hide: function() {
            var cmenu=this;
            if (cmenu.shown) {
                if (cmenu.iframe) { $(cmenu.iframe).hide(); }
                if (cmenu.menu) { cmenu.menu[cmenu.hideTransition](cmenu.hideSpeed,((cmenu.hideCallback)?function(){cmenu.hideCallback.call(cmenu);}:null)); }
                if (cmenu.shadow) { cmenu.shadowObj[cmenu.hideTransition](cmenu.hideSpeed); }
            }
            cmenu.shown = false;
        }
    };

    // This actually adds the .contextMenu() function to the jQuery namespace
    $.fn.contextMenu = function(menu,options) {
        var cmenu = $.contextMenu.create(menu,options);
        return this.each(function(){
            $(this).bind('contextmenu',function(e){cmenu.show(this,e);return false;});
        });
    };
})(jQuery);
