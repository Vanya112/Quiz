$(document).ready(function() {
        var def
    $('#grid').jsGrid(
        {
            width : '100%',
            height : 'auto',

            autoload : true,
            confirmDeleting : false,
            paging : true,
            pageSize : 10,
            pageButtonCount : 5,
            inserting : false,
            editing : false,
            filtering: true,
            sorting : true,
            controller: {
                loadData: function(filter) {
                   return $.getJSON("ajax/usertable.json?username=" + filter.username)
                                .done(function (json) {
                                    var def2 = JSON.stringify(json)
                                    def = def2;
                                })
                        },
                insertItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "ajax/usertable.json",
                        data: item
                    });
                },
                updateItem: function(item) {
                    return $.ajax({
                        type: "PUT",
                        url: "ajax/usertable.json",
                        data: item
                    });
                },
                deleteItem: function(item) {
                    return $.ajax({
                        type: "DELETE",
                        url: "ajax/usertable.json",
                        data: item
                    });
                }
            },
            // controller:{
            //     loadData: function(filter) {
            //         return $.getJSON("ajax/usertable.json?filter=" + filter.username)
            //             .done(function (json) {
            //                 var def2 = JSON.stringify(json)
            //                 def = def2;
            //             })
            //     },
            // },
            fields : [
                {
                    headerTemplate : function() {
                        return $("<button>").attr("type", "button").text("Delete").on("click",
                            function() {
                                deleteSelectedItems();
                            });
                    },
                    itemTemplate : function(_, item) {
                        return $("<input>").attr("type", "checkbox").prop("checked",
                            $.inArray(item, selectedItems) > -1).on("change", function() {
                            $(this).is(":checked") ? selectItem(item) : unselectItem(item);
                        });
                    },
                    align : "center",
                    width : 50
                }, {
                    name : "id",
                    filtering: false,
                    type : "number",
                    width : 50
                }, {
                    name : "username",
                    type : "text",
                    width : 100
                },{
                    filtering: false,
                    name : "email",
                    type : "text",
                    width : 100
                },{
                    filtering: false,
                    name : "isActive",
                    type : "checkbox",
                    width : 100
                }, ]
        });

    var selectedItems = [];

    var selectItem = function(item) {
        selectedItems.push(item);
    };

    var unselectItem = function(item) {
        selectedItems = $.grep(selectedItems, function(i) {
            return i !== item;
        });
    };

    var deleteSelectedItems = function() {
        if (!selectedItems.length || !confirm("Are you sure?"))
            return;
        deleteFromDb(JSON.stringify(selectedItems))
        console.log(JSON.stringify(selectedItems))
        var $grid = $("#jsGrid");
        $grid.jsGrid("option", "pageIndex", 1);
        $grid.jsGrid("loadData");
        selectedItems = [];
    };

    function getXmlHttp() {
        var xmlhttp;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (E) {
                xmlhttp = false;
            }
        }
        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }


    function deleteFromDb(data) {
        var xmlhttp = getXmlHttp(); // Создаём объект XMLHTTP

        var x = new XMLHttpRequest();
        x.open("GET", "ajax/usertable/edit?type=delete&data="+data, true);
            x.onload = function (){
            }
        x.send(null);
        };

})


//
// controller:{
//     loadData: function(filter) {
//         return $.getJSON("ajax/usertable.json")
//             .done(function (json) {
//                 var def2 = JSON.stringify(json)
//                 def = def2;
//                 console.log(def);
//             })
//     }},