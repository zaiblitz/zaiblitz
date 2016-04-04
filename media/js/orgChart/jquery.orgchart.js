(function($) {
	var counter2=1;
	var width_each_row=0;
	var increment_width=180;
	function dump(arr,level) {
		var dumped_text = "";
		if(!level) level = 0;
		
		//The padding given at the beginning of the line.
		var level_padding = "";
		for(var j=0;j<level+1;j++) level_padding += "    ";
		
		if(typeof(arr) == 'object') { //Array/Hashes/Objects 
			for(var item in arr) {
				var value = arr[item];
				
				if(typeof(value) == 'object') { //If it is an array,
					dumped_text += level_padding + "'" + item + "' ...\n";
					dumped_text += dump(value,level+1);
				} else {
					dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
				}
			}
		} else { //Stings/Chars/Numbers etc.
			dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
		}
		return dumped_text;
	}
	
	var employee_id_for_field = '';
	function loadAutoSuggestForOrgChart(){
		$.post(base_url + 'company_setup/org_structure', {
            action: 'get_employees_full_name'
	    }, function(data) {
			var availableNos = jQuery.parseJSON(data);
			$(".org-input").autocomplete({
                source: availableNos,
                backdrop: 'static',
                maxItems: 1,
                select: function(event, ui) {
	                if (ui.item && ui.item.value) {
						titleinput = ui.item.value;
                        ui.item.value = $.trim(titleinput);
                        $(".org-input").val(ui.item.value);
                        getEmployeeInfo('fullName');
                    }
                }
            });
        });
	}
	
	function getEmployeeInfo(param){
		$.post(base_url + 'company_setup/org_structure', {
				type:param,
				action:'get_employee_name_auto_suggest_lookup',
	        	emp_name:$(".org-input").val(),
		        emp_no: ''
		    }, function(data) {
				var obj = $.parseJSON(data);
		        if (obj.exists === true) {
		            var obj = $.parseJSON(data);
		            if(param =='fullName'){
		                //$("#employee_number").val(obj.data.employeeNo);
		            }else{
		                $(".org-input").val(obj.data.fullName);
		            }
		            employee_id_for_field = obj.data.employeeId;
					$(".employeeId").val(obj.data.employeeId);
		        } else {
		        	toastr.warning("Employee does not exists.");
		            $("#empId").val("");
					$(".org-input").val("");
		            //$("#employee_number").val("");
		        }
		    });
	}
	
	
    $.fn.orgChart = function(options) {
        var opts = $.extend({}, $.fn.orgChart.defaults, options);
        return new OrgChart($(this), opts);        
    }

    $.fn.orgChart.defaults = {
        data: [{id:1, name:'Root', parent: 0}],
        showControls: false,
        allowEdit: false,
        onAddNode: null,
        onDeleteNode: null,
        onClickNode: null,
        newNodeText: 'Add Child'
    };

    function OrgChart($container, opts){
        var data = opts.data;
        var nodes = {};
        var rootNodes = [];
        this.opts = opts;
        this.$container = $container;
        var self = this;

        this.draw = function(){
            $container.empty().append(rootNodes[0].render(opts));
            $container.find('.node').click(function(){
                if(self.opts.onClickNode !== null){
                    self.opts.onClickNode(nodes[$(this).attr('node-id')]);
                }
            });

            if(opts.allowEdit){
                $container.find('.node h2').click(function(e){
                    var thisId = $(this).parent().attr('node-id');
                    self.startEdit(thisId);
                    e.stopPropagation();
                });
            }
            
            // add "add button" listener
            $container.find('.org-add-button').click(function(e){
                var thisId = $(this).parent().attr('node-id');

                if(self.opts.onAddNode !== null){
                    self.opts.onAddNode(nodes[thisId]);
                }
                else{
                    self.newNode(thisId);
                }
                e.stopPropagation();
            });

            $container.find('.org-del-button').click(function(e){
                var thisId = $(this).parent().attr('node-id');
                if(self.opts.onDeleteNode !== null){
                    self.opts.onDeleteNode(nodes[thisId]);
                }
                else{
                    self.deleteNode(thisId);
                }
                e.stopPropagation();
            });
        }

        this.startEdit = function(id){
        	var inputElement = $('<input class="org-input" type="text" value="'+nodes[id].data.name+'"/>');
            $container.find('div[node-id='+id+'] h2').replaceWith(inputElement);
            var commitChange = function(){
            	var h2Element = $('<h2>'+nodes[id].data.name+' <input type = "hidden" class = "employeeId" value = "'+employee_id_for_field+'"></h2>');
                if(opts.allowEdit){
                    h2Element.click(function(){
                        self.startEdit(id);
                    })
                }
                inputElement.replaceWith(h2Element);
            }  
            inputElement.focus();
            inputElement.keyup(function(event){
                if(event.which == 13){
                    commitChange();
                    nodes[id].data.employeeId = employee_id_for_field;
                }
                else{
                	
                    nodes[id].data.name = inputElement.val();
                }
            });
            inputElement.blur(function(event){
                commitChange();
            })
        
            loadAutoSuggestForOrgChart();
        }

        this.newNode = function(parentId){
            var nextId = Object.keys(nodes).length;
            while(nextId in nodes){
                nextId++;
            }

            self.addNode({id: nextId, name: '', parent: parentId});
        }

        this.addNode = function(data){
            var newNode = new Node(data);
            nodes[data.id] = newNode;
            nodes[data.parent].addChild(newNode);

            self.draw();
            self.startEdit(data.id);
        }

        this.deleteNode = function(id){
            for(var i=0;i<nodes[id].children.length;i++){
                self.deleteNode(nodes[id].children[i].data.id);
            }
            nodes[nodes[id].data.parent].removeChild(id);
            delete nodes[id];
            self.draw();
        }

        this.getData = function(){
            var outData = [];
            for(var i in nodes){
                outData.push(nodes[i].data);
            }
            return outData;
        }

        // constructor
        for(var i in data){
            var node = new Node(data[i]);
            nodes[data[i].id] = node;
        }

        // generate parent child tree
        for(var i in nodes){
            if(nodes[i].data.parent == 0){
                rootNodes.push(nodes[i]);
            }
            else{
                nodes[nodes[i].data.parent].addChild(nodes[i]);
            }
            width_each_row=width_each_row+increment_width;
        }
        //width_each_row = width_each_row*2;
        // draw org chart
        $container.addClass('orgChart');
        self.draw();
    }
    
    function Node(data){
        this.data = data;
        this.children = [];
        var self = this;

        this.addChild = function(childNode){
            this.children.push(childNode);
        }

        this.removeChild = function(id){
            for(var i=0;i<self.children.length;i++){
                if(self.children[i].data.id == id){
                    self.children.splice(i,1);
                    return;
                }
            }
        }
        
        this.render = function(opts){
            var childLength = self.children.length,
                mainTable;
            
            mainTable = "<table cellpadding='0' cellspacing='0' border='0'  >";
            var nodeColspan = childLength>0?2*childLength:2;
            mainTable += "<tr><td colspan='"+nodeColspan+"' >"+self.formatNode(opts)+"</td></tr>";

            //get highest number of child
            //if(childLength > 0){
            	//for(var z=0;z<childLength;z++){
            		
            	//}
            //}
            //var width_each_row2 = width_each_row * 2;
            
            if(childLength > 0){
                var downLineTable = "<table cellpadding='0' cellspacing='0' border='0'><tr class='lines x'><td class='line left half'></td><td class='line right half'></td></table>";
                mainTable += "<tr class='lines'><td colspan='"+childLength*2+"'  >"+downLineTable+'</td></tr>';
                
                var linesCols = '';
                for(var i=0;i<childLength;i++){
                	
                	//alert(opts.data[counter2].positionRank);
                	//alert(counter2);
                	//alert(childLength);
                	
                	 if(childLength==1){
                         linesCols += "<td class='line left half'  ></td>";    // keep vertical lines aligned if there's only 1 child
                     }
                     else if(i==0){
                     	linesCols += "<td class='line left'  ></td>";     // the first cell doesn't have a line in the top
                     }
                     else{
                         linesCols += "<td class='line left top' ></td>";
                     }

                     if(childLength==1){
                         linesCols += "<td class='line right half' ></td>";
                     }
                     else if(i==childLength-1){
                         linesCols += "<td class='line right'></td>";
                     }
                     else{
                         linesCols += "<td class='line right top'></td>";
                     }
                     counter2= counter2+1;
                     //width_each_row=width_each_row-increment_width;
                }
                mainTable += "<tr class='lines v'>"+linesCols+"</tr>";

                mainTable += "<tr>";
                
                for(var i in self.children){
                    mainTable += "<td colspan='2' style = 'width:"+100/childLength+"%;'>"+self.children[i].render(opts)+"</td>";
                }
                mainTable += "</tr>";
                //if(i==0){
               	 	//width_each_row = width_each_row/2;
                //}
            }
            mainTable += '</table>';
            
            return mainTable;
        }

        this.formatNode = function(opts){
            var nameString = '',
                descString = '';
            if(typeof data.employeeId !== 'undefined'){
                descString = '<input type = "hidden" class = "employeeId"   value = "'+self.data.employeeId+'"> ';
            }
            if(typeof data.name !== 'undefined'){
                nameString = '<h2>'+self.data.name+' <input type = "hidden" class = "employeeId" value = "'+self.data.employeeId+'"></h2>';
            }
            if(typeof data.description !== 'undefined'){
                descString = '<p>'+self.data.description+'</p>';
            }
            
            if(opts.showControls){
                var buttonsHtml = "<div class='org-add-button'>"+opts.newNodeText+"</div><div class='org-del-button'></div>";
            }
            else{
                buttonsHtml = '';
            }
            return "<div class='node' node-id='"+this.data.id+"'>"+nameString+descString+buttonsHtml+"</div>";
        }
    }

})(jQuery);

