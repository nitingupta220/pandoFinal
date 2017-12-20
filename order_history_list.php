<script src="<?php echo site_url()." assets/angular/ ";?>app-inbound.js"></script>
<script type="text/javascript">
    var waitingDialog = waitingDialog || (function($) {

        // Creating modal dialog's DOM
        var $dialog = $(
            '<div class="modal fade"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-m">' +
            '<div class="loading-bar blow">' +
            '<div></div><div></div><div></div><div></div><div></div>' +
            '</div></div></div>');

        return {
            /**
             * Opens our dialog
             * @param message Custom message
             * @param options Custom options:
             * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
             * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
             */
            show: function(message, options) {
                // Assigning defaults
                if (typeof options === 'undefined') {
                    options = {};
                }
                if (typeof message === 'undefined') {
                    message = 'Loading';
                }
                var settings = $.extend({
                    dialogSize: 'm',
                    progressType: '',
                    onHide: null // This callback runs after the dialog was hidden
                }, options);

                // Configuring dialog
                $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
                $dialog.find('.progress-bar').attr('class', 'progress-bar');
                if (settings.progressType) {
                    $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                }
                $dialog.find('h3').text(message);
                // Adding callbacks
                if (typeof settings.onHide === 'function') {
                    $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
                        settings.onHide.call($dialog);
                    });
                }
                // Opening dialog
                $dialog.modal();
            },
            /**
             * Closes dialog
             */
            hide: function() {
                $dialog.modal('hide');
            }
        };

    })(jQuery);

</script>
<div class="menu_content" ng-app="pandoApp" ng-controller="OrderController">
    <?php $this->load->view('ohistory_nav_menu.php');?>
    <div class="overlay-outer">
        <!--<div class="overlay"></div>-->
        <div class="submenu_content">
            <div class="header">
                <div class="back_to_slide"><a href="javascript:void(0);" class="back_to_slide glyphicon glyphicon-arrow-left" data-toggle="tooltip" title="Back to Menu" data-placement="right"></a></div>
                <div class="col-xs-5 col-sm-6 no-padding">
                    <h1 ng-click="Url_viewOrd('54')">Order Details</h1>
                </div>
                <!--<div class="col-xs-5 col-sm-5 text-right">
          <?php $this->load->view('notification_dropdown');?>
          <img src="<?php echo site_url()."assets/";?>images/logo-pando.png" width="71" height="42" alt="Pando"/>
      </div>-->
                <div class="alert alert-danger" id="error_yes"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{err_msg}}</div>
                <div class="alert alert-success" id="error_no"><i class="fa fa-check-circle" aria-hidden="true"></i> {{err_msg}}</div>

            </div>

            <div class="order-content">
                <div class="tab-content">

                    <div ng-if="!view_ord">
                        <!--<div class="new-order-sec"><img src="<?php echo base_url();?>assets/images/new-order.png" width="61" height="51" alt=""/>
<br>
<h2>You haven't created any order yet,<br>
Create a new order and get started.</h2>
</div>-->
                    </div>

                    <?php if($this->uri->segment(2) !=""){?> {{Url_viewOrd('
                    <?php echo $this->uri->segment(2);?>')}}
                    <?php }?>
                    <div ng-if="view_ord" ng-init="parent_indexid = sectionIndex" class="tab-pane active">
                        <div class="flex-container">
                            <div class="col-sm-12 flex-item text-content no-padding">
                                <div class="form-comm-pad">
                                    <div ng-if="view_ord.order_in != 'Group'">
                                        <div class="col-md-12 col-lg-6"><span class="new">Gate</span>
                                            <div class="order_values" ng-bind="view_ord.consignee[0].gate_list.gate_number"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6"><span>Logorg</span>
                                        <div class="order_values" ng-bind="view_ord.plp_name"></div>
                                    </div>

                                    <div class="col-md-12 col-lg-6"><span>Delivery to</span>
                                        <div class="order_values" ng-if="view_ord.consignee.length > 1"> Multiple Locations</div>
                                        <div class="order_values" ng-if="view_ord.consignee.length == 1" ng-bind="view_ord.consignee[0].consignee_name"></div>
                                    </div>

                                    <div ng-hide="view_ord.order_type == 'Ex-work'" class="col-md-12 col-lg-6"><span>Transport Vendor</span>
                                        <div class="order_values" ng-bind="view_ord.vendor_name"> </div>
                                    </div>
                                </div>
                                <div class="form-comm-pad bdr">
                                    <div class="col-sm-4"><span>Order ID </span>
                                        <div class="order_values" ng-bind="view_ord.order_ref"></div>
                                    </div>
                                    <div class="col-sm-4 order_padding"> <span>Created </span>
                                        <div class="order_values" ng-bind="view_ord.created_date"></div>
                                    </div>
                                    <div class="col-sm-4 order_padding"> <span>Order Type </span>
                                        <div class="order_values" ng-if="view_ord.order_type !='Ex-work'" ng-bind="view_ord.order_type"> </div>
                                        <div class="order_values" ng-if="view_ord.order_type =='Ex-work'">No Freight</div>
                                    </div>
                                    <div class="col-sm-4 order_padding" ng-if="view_ord.order_type !='Ex-work'"><span>Delivery Type </span>
                                        <div class="order_values" ng-bind="view_ord.delivery_type"></div>
                                    </div>
                                    <div class="col-sm-4 order_padding" ng-if="view_ord.order_type =='Ex-work'"><span>Type </span>
                                        <div class="order_values" ng-bind="view_ord.type"></div>
                                    </div>

                                    <div class="col-sm-4" ng-if="view_ord.order_type !='Ex-work'"> <span>Vehicle Type</span>
                                        <div class="order_values" ng-bind="view_ord.vehicle_name"></div>
                                    </div>
                                    <!--   <div class="col-sm-4 order_padding"> <span>Loaders Available </span>
          <div class="order_values" ng-bind="view_ord.loader_avb"></div></div>
          <div class="col-sm-4 order_padding"><span>Loaders Paid by </span>
          <div class="order_values" ng-bind="view_ord.loading_by"> Transporter</div></div>-->
                                    <div class="col-sm-4 order_padding" ng-if="view_ord.order_type !='Ex-work'"><span>Contracted Price</span>
                                        <div class="order_values" ng-bind="view_ord.contracted_price"> </div>
                                    </div>
                                </div>
                                <!-- Truck modal start here -->
                                <div id="truck{{parent_indexid}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="popup-truck-bg" style='background-image: url("{{view_ord.vehicle.vehicle_photo}}");'>
                                            </div>
                                            <div class="modal-body">
                                                <div class="panel-body login_body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h4>Truck Details</h4>
                                                        </div>
                                                    </div>
                                                    <div class="row" ng-init="vch = view_ord.vehicle">

                                                        <div class="col-sm-6"><span>Truck Number</span> {{vch.frm_truckno}}<br>
                                                            <br>
                                                            <span>Make</span> {{vch.frm_make}}<br>
                                                            <br>
                                                            <span>Insurance</span> Valid till {{vch.frm_insurance_validtill}}<br>

                                                        </div>
                                                        <div class="col-sm-6"><span>Truck Type</span> {{vch.frm_trucktype}}<br>
                                                            <br>
                                                            <span>Model</span> {{vch.frm_model}}<br>
                                                            <br>
                                                            <span>Fitness Certificate</span>Valid till {{vch.frm_fitness_certivalidtill}}<br>
                                                        </div>
                                                    </div>

                                                    <div class="row driver-img">
                                                        <!--<img ng-src="{{view_ord.driver.frm_driverimg}}" width="92" height="91" alt=""/>--><label for="file-upload" class="custom-file-upload"> Add<br>
             Driver<br>
Photo </label>
                                                        <input id="file-upload" file-model="myFile" type="file" /></div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h4>Driver Details</h4>
                                                        </div>
                                                    </div>
                                                    <div class="row" ng-init="drv = view_ord.driver">
                                                        <div class="col-sm-6"> <span>Driver Name</span> {{drv.frm_drivername}}<br>
                                                            <br>
                                                            <span>Mobile Nunber</span> {{drv.frm_phoneno}}<span></span> </div>
                                                        <div class="col-sm-6"><span>License</span> {{drv.frm_driverlno}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end login Form -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Truck modal ends here -->
                                <!-- Single , multiple & group start here -->
                                <div class="form-comm-pad bdr">
                                    <div class="consignment-container">
                                        <div class="consignment-sec" ng-repeat="(key,con) in view_ord.consignee">
                                            <div class="order-content-status" ng-if='view_ord.order_in == "Single"'>

                                                <div class="panel-group" id="accordion">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne-{{parent_indexid}}-{{$index}}">
                                                                    <div class="col-sm-2 no-padding"><span>LR Number</span>
                                                                        <div ng-if="view_ord.filter_status !='Delivered'">

                                                                            <form name="formLrname" class="form-inline" ng-if="con.lr_no_true == false">
                                                                                <div class="form-group " ng-class="{'has-error': formLrname.$valid == false}">
                                                                                    <span ng-init="con.lr_noupdate = con.lr_no"></span>



                                                                                    <input type="text" required class="form-control lr-txt" ng-model="con.lr_noupdate" id="exampleInputEmail2" placeholder="">
                                                                                    <button type="button" ng-click="con.lr_no_true = !con.lr_no_true" class="btn btn-lr cancel-lr">Cancel</button>
                                                                                    <button type="button" ng-click="updateLRno(con.lr_noupdate,$index,parent_indexid,view_ord.order_id)" class="btn btn-lr">Save</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <span ng-if="con.lr_no_true == true">
	{{con.lr_no | limitTo: 8}}<br>
	<button href="javascript:;" class="editLr-no btn-read" style="text-decoration:underline" ng-if="con.dispatch_status == 'N' && view_ord.order_type !='Ex-work'" ng-click="con.lr_no_true = !con.lr_no_true">Edit</button>
	<button href="javascript:;" class="editLr-no btn-read" style="text-decoration:underline" ng-if="view_ord.order_type =='Ex-work' && con.delivery_status =='N'" ng-click="con.lr_no_true = !con.lr_no_true">Edit</button>
	</span>

                                                                    </div>
                                                                    <div class="col-sm-4"><span>Consignee Name</span>{{con.consignee_name}}</div>
                                                                    <div class="col-sm-3 no-padding"><span>Expected Date</span>{{con.expected_delivery}} </div>
                                                                    <div class="col-sm-2 no-padding" style="width:21%"><span>Status</span> {{con.each_status}}
                                                                        <button class="btn-read" style="text-decoration:underline" ng-if="view_ord.order_type !='Ex-work'" data-toggle="modal" ng-hide="con.each_status =='Delivered' || con.dispatch_status == 'N' || view_ord.filter_status =='Cancelled' || view_ord.filter_status =='Intended'" data-target=".markas-{{parent_indexid}}-{{$index}}"> Mark as Delivered</button>
                                                                        <button class="btn-read" style="text-decoration:underline" ng-if="view_ord.order_type =='Ex-work'" data-toggle="modal" ng-hide="con.each_status =='Delivered' || con.dispatch_status == 'N' || view_ord.filter_status =='Cancelled'" data-target=".markas-{{parent_indexid}}-{{$index}}"> Mark as Delivered</button>
                                                                    </div>

                                                                </a>
                                                            </h4>



                                                        </div>
                                                        <div id="collapseOne-{{parent_indexid}}-{{$index}}" class="panel-collapse collapse in">
                                                            <div class="col-sm-7">
                                                                <p><span>Unloading Point</span> {{con.consignee_address}}
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-5" ng-if="view_ord.order_type !='Ex-work'">
                                                                <p><span>Unloaders</span>
                                                                    <span ng-if="con.unloader_avb == 'Yes'">Available</span>
                                                                    <span ng-if="con.unloader_avb == 'No'">Unavailable</span> {{con.unloading_by}} </p>
                                                            </div>
                                                            <ul class="horizontal-bar" ng-if="view_ord.order_type !='Ex-work'">
                                                                <li ng-class="{'active': con.truck_status == 'Y', 'nobar': con.arrived_status != 'Y'}"><span>Assigned <span class="date">{{con.truck_assigned_date}}</span></span>
                                                                </li>
                                                                <li ng-class="{'active': con.arriving_status == 'Y' || con.arrived_status == 'Y', 'nobar': con.arrived_status != 'Y'}"><span>Arriving <span class="date">{{con.arriving_date}}</span></span>
                                                                </li>
                                                                <li ng-class="{'active': con.arrived_status == 'Y', 'nobar': con.dispatch_status != 'Y'}"><span>Arrived <span class="date">{{con.arrived_date}}</span></span>
                                                                </li>
                                                                <li ng-class="{'active': con.dispatch_status == 'Y', 'nobar': con.delivery_status != 'D'}"><span>Dispatched <span class="date">{{con.dispatch_date}}</span></span>
                                                                </li>
                                                                <li ng-class="{'active': con.delivery_arriving_status == 'Y' || con.delivery_status == 'D', 'nobar': con.delivery_status != 'D'}"><span>Delivering <span class="date" ng-if="con.delivery_arriving_date !=''">{{con.delivery_arriving_date}}</span><span class="date" ng-if="con.delivery_arriving_date ==''">{{con.delivery_date}}</span></span>
                                                                </li>
                                                                <li ng-class="{'active': con.delivery_status == 'D'}"><span>Delivered <span class="date">{{con.POD_date}}</span></span>
                                                                </li>
                                                            </ul>

                                                            <!-- 
		  
		  <div class="horizontal-bar-sub" ng-if="con.arrived_status == 'Y'">
            
            <ul class="horizontal-bar-sub"><div class="timing" ng-if="con.loading_end == 'Y'">Loading time: <div ng-bind="con.loading_diff">Hours</div></div>
			<div class="timing" ng-if="con.loading_end == 'Y'">No Of Units dispatched : <div ng-bind="con.noofUnits">Hours</div></div>
             <li ng-class="{'active': con.loading_started == 'Y', 'nobar': con.loading_end == 'N'}">
              <div class="hori_text">
               <a ng-if="con.loading_started == 'N'" href="javascript:;"  ng-class="{'btn-disabled': con.dispatch_status == 'Y'}" ng-disabled="con.dispatch_status == 'Y'" ng-click="loadingStarted(view_ord.order_id,key)" class="btn btn-disable">Loading Started</a>
               <span ng-if="con.loading_started == 'Y'" ng-bind="con.loading_time"></span>
               </div>
              </li>
             <li ng-class="{'active': con.loading_end == 'Y'}">
              <div class="hori_text">
               <a href="javascript:;" ng-if="con.loading_end == 'N'" ng-class="{'btn-disabled': con.loading_started == 'N' || con.dispatch_status == 'Y'}" ng-disabled="con.loading_started == 'N' || con.dispatch_status == 'Y'" class="btn" data-toggle="modal" data-target="#unit-disp-{{parent_indexid}}-{{$index}}" >Loading Ended</a>
			   
			   
			   <div class="modal fade small_modal" id="unit-disp-{{parent_indexid}}-{{$index}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Units</h4>
      </div>
      <div class="modal-body " style="padding:0px;">
	  <span ng-init="noofUnits = ''"></span>
        
		<div class="row">
                   <div class="form-group">
                    <div class="col-xs-5 col-sm-4 pad-right-0" style="font-size:13px;">No of units dispatched</div>
                    <div class="col-xs-2 col-sm-4 no-padding">
                     <input type="text" class="form-control" digit-only="" autocomplete="off" ng-model="noofUnits" id="noofUnits" placeholder="">
                    </div>
                    <div class="col-xs-5 col-sm-4"></div>
                   </div>
				   <div class="clearfix"></div>
				    <br>
				   <div class="text-center">        
        <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="loadingEnd(view_ord.order_id,key,noofUnits)" >Save</button>
      </div>
	  <div class="clearfix"></div>
	  <br>
                  </div>
		
      </div>
      
    </div>
  </div>
</div>
               <span ng-if="con.loading_end == 'Y'" ng-bind="con.loading_end_time"></span>
               </div>	
              </li>
            </ul></div>--->

                                                            <div class="order-truck-icons" ng-if="con.truck_status == 'Y'">
                                                                <a href="" data-toggle="modal" data-target="#truck{{parent_indexid}}" class="icon-truck-order">Truck Details</a></div>
                                                            <!--<div class="order-truck-icons" ng-if="con.dispatch_status == 'Y'"><a href=""  data-toggle="modal" data-target="#gatem{{parent_indexid}}-{{$index}}" class="icon-truck-gp">Gate Pass</a></div>-->
                                                            <div class="order-truck-icons" ng-if="con.truck_status == 'Y'"><a href="" data-toggle="modal" data-target="#lr{{parent_indexid}}-{{$index}}" class="icon-truck-lr">LR Details</a></div>
                                                            <div class="order-truck-icons" ng-if="con.dispatch_status == 'Y'"><a href="<?php echo site_url();?>tracking/order/{{con.hypertracking_by}}/{{con.hyperconsignee_id}}" target="_blank" class="icon-truck-location">Truck Location</a></div>
                                                            <div class="order-truck-icons1" ng-if="con.delivery_status == 'D'" ng-class="{exworkproof: view_ord.order_type == 'Ex-work'}"><a href="" data-toggle="modal" data-target="#podm{{parent_indexid}}-{{$index}}" class="icon-truck-pod">Proof of Delivery</a>
                                                            </div>


                                                            <div class="col-sm-12">

                                                                <a data-target="#viewSLA{{parent_indexid}}-{{$index}}-0" ng-if="view_ord.order_type == 'Open'" data-toggle="modal" class="btn ">View SLA</a>
                                                                <b ng-if="con.dispatch_status == 'Y'">&nbsp;Units Dispatched: {{con.noofUnits}}</b>
                                                                <span ng-init="sla = con.sla_details"></span>



                                                                <!-- modal setting start -->
                                                                <div id="viewSLA{{parent_indexid}}-{{$index}}-0" ng-if="view_ord.order_type == 'Open'" class="modal fade " role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">

                                                                            <header>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h1>SLA Settings</h1>

                                                                                <div class="alert alert-danger pop_error_yes"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                                                <div class="alert alert-success pop_error_no"><i class="fa fa-check-circle" aria-hidden="true"></i> {{uerr_msg}}</div>

                                                                            </header>
                                                                            <div class="modal-body">
                                                                                <div class="panel-body login_body">
                                                                                    <ul class="nav nav-tabs">
                                                                                        <li class="active"><a data-toggle="tab" href="#price{{parent_indexid}}-{{$index}}">Contracted Rates</a></li>
                                                                                        <li><a data-toggle="tab" href="#time{{parent_indexid}}-{{$index}}">SLA Time</a></li>
                                                                                    </ul>
                                                                                    <div class="tab-content">
                                                                                        <div id="price{{parent_indexid}}-{{$index}}" class="tab-pane fade in active"> <br>
                                                                                            <div class="row">
                                                                                                <div class="col-xs-5 col-sm-4 title"><span>Charge Type</span></div>
                                                                                                <div class="col-xs-2 col-sm-4 no-padding title"><span>Amount</span></div>
                                                                                                <div class="col-xs-5 col-sm-4 title"><span>Unit</span></div>
                                                                                            </div>


                                                                                            <div class="row" ng-if="sla.type =='Matrix'">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0"></div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        &nbsp;
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4">

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Contracted Freight Charges</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.freight_charges" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4">
                                                                                                        <select class="form-control" disabled ng-model="sla.freight_unit">
                       <option value="">Select type</option>
                       <option value="per_trip">Per Trip</option>
                       <option value="per_kg">Per Kg</option>
                       <option value="volumetric">Volumetric</option>
                     </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row" ng-if="sla.freight_unit == 'per_kg' || sla.freight_unit == 'volumetric'">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Minimum Guarantee Rate</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.minimum_rate" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4"> </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row" ng-if="sla.freight_unit == 'per_kg'">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Multiplying factor</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.multiplying_factor" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4"> </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Cancellation Charges</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.cancellation_charges" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4"></div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Loading Detention Charges (Cumulative)</div>
                                                                                                    <div class="col-xs-2 col-sm-8 no-padding">
                                                                                                        <!--- <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.detention_delay_charges" id="email" placeholder="">--->
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_1d" id="email" placeholder="Day 1">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_2d" id="email" placeholder="Day 2">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_3d" id="email" placeholder="Day 3">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_4d" id="email" placeholder="Day 4">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_5d" id="email" placeholder="Day 5">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_6d" id="email" placeholder="> Day 5">
                                                                                                    </div>
                                                                                                    <!-- <div class="col-xs-5 col-sm-4">
                     <select class="form-control" ng-if="sla.type == 'Manual'" disabled ng-model="sla.detention_delay_unit">
                      <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>
                     <select class="form-control" ng-if="sla.type != 'Manual'" disabled ng-model="sla.detention_delay_unit">
                      <option value="">Per - day(Progressive)</option>
                     </select>
                    </div>--->
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Transit Delay Penalty (Cumulative)</div>
                                                                                                    <div class="col-xs-2 col-sm-8 no-padding">
                                                                                                        <!--- <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.delivery_delay_charges" id="email" placeholder="">--->
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_1d" id="email" placeholder="Day 1">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_2d" id="email" placeholder="Day 2">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled disabled ng-model="sla.ddelivery_3d" id="email" placeholder="Day 3">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_4d" id="email" placeholder="Day 4">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_5d" id="email" placeholder="Day 5">
                                                                                                        <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_6d" id="email" placeholder="> Day 5">
                                                                                                    </div>
                                                                                                    <!--  <div class="col-xs-5 col-sm-4">
                     <select class="form-control" ng-if="sla.type == 'Manual'" disabled ng-model="sla.delivery_delay_unit">
                      <option value="">Select Hours</option>
                      <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>
                        
                      <select class="form-control" ng-if="sla.type != 'Manual'" disabled ng-model="sla.delivery_delay_unit">
                      <option value="">Per - day(Progressive)</option>
                     </select>  
                        
                    </div>---->
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Unloading Delay Charges (Cumulative)</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.arrival_delay_charges" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4">
                                                                                                        <select class="form-control" ng-if="sla.type == 'Manual'" disabled ng-model="sla.arrival_delay_unit">
                      <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>

                                                                                                        <select class="form-control" ng-if="sla.type != 'Manual'" disabled ng-model="sla.arrival_delay_unit">
                      <option value="">Per - day(Progressive)</option>
                     </select>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">LR Charges</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.lr_charge" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4"> </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Loading Charges</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.loading_charge" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4">
                                                                                                        <select class="form-control" disabled ng-model="sla.loading_unit2">
                      <option value="">Select</option>
                      <option value="Per-KG">Per-KG</option>
                      <option value="Per-Order">Per-Order</option>
                     </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Unloading Charges</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.unloading_charge" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4">
                                                                                                        <select class="form-control" disabled ng-model="sla.unloading_unit2">
                      <option value="">Select</option>
                      <option value="Per-KG">Per-KG</option>
                      <option value="Per-Order">Per-Order</option>
                     </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>

                                                                                        <div id="time{{parent_indexid}}-{{$index}}" class="tab-pane fade"> <br>
                                                                                            <div class="row">
                                                                                                <div class="col-xs-5 col-sm-4 title"><span>Charge Type</span></div>
                                                                                                <div class="col-xs-2 col-sm-4 no-padding title"><span ng-if="sla.type == 'Manual'">Value in hours</span><span ng-if="sla.type != 'Manual'">Value in days</span></div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Maximum Unloading Time Allowed</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only maxlength="2" autocomplete="off" disabled ng-model="sla.arrival_time" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4">
                                                                                                        <!--  <select class="form-control" ng-model="sla.arrival_unit">
                       <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                       <option value="12">12</option>
                       <option value="24">24</option>
                     </select>-->

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Maximum Loading Time Allowed</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only maxlength="2" autocomplete="off" disabled ng-model="sla.loading_time" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4">

                                                                                                        <!--  <select class="form-control" ng-model="sla.loading_unit">
                      <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>-->

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-xs-5 col-sm-4 pad-right-0">Maximum Transit Time Allowed</div>
                                                                                                    <div class="col-xs-2 col-sm-4 no-padding">
                                                                                                        <input type="text" class="form-control" digit-only maxlength="2" autocomplete="off" disabled ng-model="sla.transit_time" id="email" placeholder="">
                                                                                                    </div>
                                                                                                    <div class="col-xs-5 col-sm-4">

                                                                                                        <!--    <select class="form-control" ng-model="sla.transit_unit">
                      <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>-->

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>







                                                                                        </div>

                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <!--end login Form -->
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- modal setting ends -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material_sec">


                                                <div class="modal fade markas-{{parent_indexid}}-{{$index}}" id="markas-{{parent_indexid}}-{{$index}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                                    <div class="modal-dialog modal-sm" role="document">
                                                        <div class="modal-content">

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h1 class="ng-binding">Mark as Delivered</h1>
                                                            <div class="modal-body">
                                                                <span style="display: none" class="rep_err alert alert-danger">{{rep_err}}</span>

                                                                <span ng-init="selectedDate.hour = '<?php echo date(" H "); ?>';selectedDate.min = '<?php echo date("i "); ?>';selectedDate.deliverydate = '<?php echo date("d/m/Y "); ?>';selectedDate.podhour = '<?php echo date("H "); ?>';selectedDate.podmin = '<?php echo date("i "); ?>';selectedDate.poddate = '<?php echo date("d/m/Y "); ?>';"></span>
                                                                <form name="markForm">
                                                                    <div class="form-group">
                                                                        <label class="labels" for="exampleInputEmail1">Reporting date <i class="txt-red">*</i></label>
                                                                        <div class="label-fields"><input type="text" class="form-control datefield datepicker" id="" readonly="" required ng-model="selectedDate.deliverydate" datepicker placeholder="Delivery Date"></div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-sm-6 col-lg-6" for="email">Reporting Hours & Minutes  <i class="txt-red">*</i> :</label>
                                                                        <div class="col-sm-3 col-lg-3">
                                                                            <select required="" ng-model="selectedDate.hour" class="form-control time"><option value="">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
                                                                        </div>
                                                                        <div class="col-sm-3 col-lg-3">
                                                                            <select required="" ng-model="selectedDate.min" class="form-control time"><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
                                                                        </div>
                                                                    </div>


                                                                    <div class="clearfix"></div>
                                                                    <br>
                                                                    <div class="form-group">
                                                                        <label class="labels" for="exampleInputEmail1">Vehicle Release date <i class="txt-red">*</i></label>
                                                                        <div class="label-fields"><input type="text" class="form-control datefield datepicker" id="" readonly="" required ng-model="selectedDate.poddate" datepicker placeholder="Delivery Date"></div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label class="col-sm-6 col-lg-6" for="email">Vehicle Release Hours & Minutes  <i class="txt-red">*</i> :</label>
                                                                        <div class="col-sm-3 col-lg-3">
                                                                            <select required="" ng-model="selectedDate.podhour" class="form-control time"><option value="">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
                                                                        </div>
                                                                        <div class="col-sm-3 col-lg-3">
                                                                            <select required="" ng-model="selectedDate.podmin" class="form-control time"><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
                                                                        </div>
                                                                    </div>


                                                                    <div class="clearfix"></div>
                                                                    <br>

                                                                    <span ng-init="selectedDate.material_req = 'Yes'"></span>
                                                                    <div class="form-group">
                                                                        <label class="labels" for="exampleInputEmail1">Materials delivered in full, on time and without damages <i class="txt-red">*</i></label>
                                                                        <div class="label-fields">
                                                                            <div class="inputradio col-lg-6 no-padding">
                                                                                <input id="ff-option{{$index}}" ng-model="selectedDate.material_req" value="Yes" type="radio">
                                                                                <label for="ff-option{{$index}}">Yes</label>
                                                                                <div class="check"></div>
                                                                            </div>
                                                                            <div class="inputradio col-lg-6 no-padding">
                                                                                <input id="ss-option{{$index}}" ng-model="selectedDate.material_req" value="No" type="radio">
                                                                                <label for="ss-option{{$index}}">No</label>
                                                                                <div class="check"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    <br>
                                                                    <div class="form-group">
                                                                        <label class="labels" for="exampleInputEmail1">Comments <i class="txt-red">*</i></label>
                                                                        <div class="label-fields">
                                                                            <!--<input type="text" class="form-control" id="" required ng-model="selectedDate.comments"  placeholder="Comments">-->
                                                                            <textarea class="form-control" id="" required ng-model="selectedDate.comments" placeholder=""></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    <br>
                                                                    <!--------->
                                                                    <div class="text-right">
                                                                        <button type="button" ng-click="markFormSubmit(markForm.$valid,con.dispatch_date,selectedDate,selectedDate.deliverydate,view_ord.order_id,$index,parent_indexid)" class="btn btn-default">Submit</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="material_pop{{parent_indexid}}-{{$index}}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <div class="modal-header">
                                                                <h1>Materials &amp; Quantity for {{con.consignee_name}}</h1>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="alert alert-danger pop_error_yes"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                                        <div class="alert alert-success pop_error_no"><i class="fa fa-check-circle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                                    </div>
                                                                </div>

                                                                <div class="row" ng-hide="view_ord.filter_status =='Delivered'">
                                                                    <div class="col-sm-3"><input style="display:inline;" type="file" id="file" name="file" multiple onchange="angular.element(this).scope().getFileDetails(this)" />
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <button class="btn" type="button" ng-click="uploadMateriFile(view_ord.order_id,$index,con.consignee_id)">Upload</button>
                                                                    </div>

                                                                    <div class="col-sm-6 text-right"><a href="<?php echo site_url();?>assets/sample/individual_material_bulkupload.xlsx" class="btn">Download Sample format</a></div>
                                                                </div>
                                                                <hr>


                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        Materials List:</div>

                                                                    <!--<div ng-hide="view_ord.filter_status =='Delivered'" class="col-sm-2" ng-init="edit_on = false"><a href="javascript:void(0)"  ng-click="edit_on = !edit_on"><img src="<?php echo base_url();?>assets/images/icon-delete.png"  width="18" height="21" alt=""/> Edit </a></div>-->

                                                                </div>
                                                                <div class="" style="white-space:nowrap;
    overflow-x:auto; margin-top:20px;">

                                                                    <div class="material_col"><span class="mat_title">Select</span></div>
                                                                    <div class="material_col"><span class="mat_title">Material Code</span></div>
                                                                    <div class="material_col"><span class="mat_title">Material Name</span></div>
                                                                    <div class="material_col"><span class="mat_title">Quantity</span></div>
                                                                    <div class="material_col"><span class="mat_title">BUn</span></div>
                                                                    <div class="material_col"><span class="mat_title">Gross weight</span></div>
                                                                    <div class="material_col"><span class="mat_title">WUn</span></div>
                                                                    <div class="material_col"><span class="mat_title">Volume</span></div>
                                                                    <div class="material_col"><span class="mat_title">VUn</span></div>
                                                                    <!-- <div class="material_col"><span class="mat_title">Shipment</span></div>-->
                                                                    <div class="material_col"><span class="mat_title">Delivery</span></div>
                                                                    <div class="material_col"><span class="mat_title">Bill number</span></div>
                                                                    <div class="material_col"><span class="mat_title">Shpt</span></div>

                                                                    <div class="material_col"><span class="mat_title">ship_to</span></div>
                                                                    <div class="material_col"><span class="mat_title">sold_to_pt</span></div>
                                                                    <div class="material_col"><span class="mat_title">sorg</span></div>
                                                                    <!-- <div class="col-xs-2 col-sm-2"><span class="mat_title">Delete all</span></div>-->

                                                                    <div ng-hide="con.material_arr_unknown.length == 0"><a href="javascript:void(0)" ng-click="Delete_unmaterial(view_ord.order_id,$index,con.consignee_id)"><img src="<?php echo base_url();?>assets/images/icon-delete.png"  width="18" height="21" alt=""/> Delete </a></div> <br />
                                                                    <div ng-repeat="mat in con.material_arr_unknown">
                                                                        <div class="material_col">
                                                                            <div class="checkbox" ng-init="mat.item = false">
                                                                                <input type="checkbox" style="display: block" id="tarpaulin{{$index}}" name="tarpaulin{{$index}}" ng-model="mat.item" />
                                                                                <label for="tarpaulin{{$index}}"><span></span> **{{mat.item}}</label>
                                                                            </div>

                                                                        </div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.material_code}}
                                                                            <br/>{{mat.reason}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.material}} </div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.quantity}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.bun}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.gross_weight}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.wun}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.volume}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.vun}}</div>
                                                                        <!--<div class="material_col material-pad-top">{{mat.shipment}}</div>-->
                                                                        <div class="material_col text-danger material-pad-top">{{mat.delivery}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.bill_of_lading_number | limitTo: 9}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.shpt}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.ship_to}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.sold_to_pt}}</div>
                                                                        <div class="material_col text-danger material-pad-top">{{mat.sorg}}</div>
                                                                    </div>

                                                                    <div ng-hide="view_ord.filter_status =='Delivered' || con.material_arr.length == 0"><a href="javascript:void(0)" ng-click="Delete_material(view_ord.order_id,$index,con.consignee_id)"><img src="<?php echo base_url();?>assets/images/icon-delete.png"  width="18" height="21" alt=""/> Delete </a></div>
                                                                    <br/>
                                                                    <div ng-repeat="mat in con.material_arr">
                                                                        <div class="material_col">
                                                                            <div class="checkbox" ng-init="mat.item = false">
                                                                                <input type="checkbox" style="display: block" id="tarpaulin{{$index}}" name="tarpaulin{{$index}}" ng-model="mat.item" />
                                                                                <label for="tarpaulin{{$index}}"><span></span>**{{mat.item}} </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="material_col material-pad-top">{{mat.material_code}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.material}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.quantity}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.bun}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.gross_weight}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.wun}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.volume}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.vun}}</div>
                                                                        <!--<div class="material_col material-pad-top">{{mat.shipment}}</div>-->
                                                                        <div class="material_col material-pad-top">{{mat.delivery}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.bill_of_lading_number | limitTo: 9}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.shpt}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.ship_to}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.sold_to_pt}}</div>
                                                                        <div class="material_col material-pad-top">{{mat.sorg}}</div>
                                                                    </div>
                                                                    <div ng-show="con.material_arr.length == 0">

                                                                        <div class="material-pad-top no_materials"> No materials Uploaded until now!</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Gate pass modal start here -->
                                            <div id="gatem{{parent_indexid}}-{{$index}}" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <div class="modal-body">
                                                            <div class="panel-body login_body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h1>Gate Pass Details</h1>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6"><span>Gate Name</span> {{con.gate_number}}<br>
                                                                        <br>
                                                                        <span>Managed by </span> {{con.gate_username}}<br>

                                                                    </div>
                                                                    <div class="col-sm-6"><span>Mobile no</span> {{con.gate_mobile_no}}<br>
                                                                        <br>
                                                                        <span>Email id</span> {{con.gate_email_id}}<br>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6"><br><span>Truck Arrived Date</span> {{con.arrived_date}}<br>

                                                                    </div>
                                                                    <div class="col-sm-6"><br><span>Truck Dispatch Date </span> {{con.dispatch_date}}<br>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Gate pass modal ends here -->

                                            <!-- POD modal start here -->
                                            <div id="podm{{parent_indexid}}-{{$index}}" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <div class="modal-body">
                                                            <div class="panel-body login_body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h1>POD Details</h1>
                                                                    </div>
                                                                </div>
                                                                <div class="row">

                                                                    <div ng-if="con.markedby == 'Client'">
                                                                        <b>Marked as Delivered</b>
                                                                        <br>
                                                                        <b>Comments:</b> {{con.markedbyComment}}
                                                                        <hr>
                                                                    </div>

                                                                    <div ng-if="con.completematerial.length != 0">
                                                                        <div class="col-sm-12"><span>No of units:  {{con.noofunitreceived}}</span> <br></div>
                                                                        <div class="col-sm-12" ng-repeat="(key , commat) in con.completematerial"><span>{{key}}:  {{commat}}</span> <br></div>
                                                                    </div>
                                                                    <div class="col-sm-12"><span>Materials received in full, on time and without damages:</span> {{con.pod_feedback}}<br>
                                                                        <br>
                                                                        <span>Comments :  {{con.pod_comments}}</span><br>

                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <span ng-if="con.POD_file !=''">
				  <a  href="<?php echo site_url()."assets/uploads/pod/"; ?>{{con.POD_file}}" >Click here to view</a>
                  </span>

                                                                        <span ng-if="con.POD_file ==''">
				  POD Not uploaded
                   </span>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- POD modal ends here -->


                                            <div class="" ng-if='view_ord.order_in != "Single"'>
                                                <div class="panel-group" id="accordion">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne-{{parent_indexid}}-{{$index}}">
                                                                    <div class="col-sm-2 no-padding"><span>LR Number</span>
                                                                        <div ng-if="view_ord.filter_status !='Delivered'">
                                                                            <form name="formLrname" class="form-inline" ng-if="con.lr_no_true == false">
                                                                                <div class="form-group " ng-class="{'has-error': formLrname.$valid == false}">
                                                                                    <span ng-init="con.lr_noupdate = con.lr_no"></span>
                                                                                    <input type="text" required class="form-control lr-txt" ng-model="con.lr_noupdate" id="exampleInputEmail2" placeholder="">
                                                                                    <button type="button" ng-click="con.lr_no_true = !con.lr_no_true" class="btn btn-lr cancel-lr">Cancel</button>
                                                                                    <button type="button" ng-click="updateLRno(con.lr_noupdate,$index,parent_indexid,view_ord.order_id)" class="btn btn-lr">Save</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>

                                                                        <span ng-if="con.lr_no_true == true">
	{{con.lr_no | limitTo: 8}}<br>
	<button href="javascript:;" class="editLr-no btn-read" style="text-decoration:underline" ng-if="con.dispatch_status == 'N' && view_ord.order_type !='Ex-work'" ng-click="con.lr_no_true = !con.lr_no_true">Edit</button>
	<button href="javascript:;" class="editLr-no btn-read" style="text-decoration:underline" ng-if="view_ord.order_type =='Ex-work' && con.delivery_status =='N'" ng-click="con.lr_no_true = !con.lr_no_true">Edit</button>
	</span>

                                                                    </div>
                                                                    <div class="col-sm-4 no-padding"><span>Consignee Name</span>{{con.consignee_name}}</div>
                                                                    <div class="col-sm-3 no-padding"><span>Expected Date</span>{{con.expected_delivery}} </div>
                                                                    <div class="col-sm-2 no-padding" style="width:21%"><span>Status</span>{{con.each_status}}
                                                                        <button data-toggle="modal" ng-if="view_ord.order_type !='Ex-work'" class="btn-read" ng-hide="con.each_status =='Delivered' || con.dispatch_status == 'N' || view_ord.filter_status =='Cancelled' || view_ord.filter_status =='Intended'" data-target=".markas-{{parent_indexid}}-{{$index}}"> Mark as Delivered</button>
                                                                        <button data-toggle="modal" ng-if="view_ord.order_type =='Ex-work'" class="btn-read" ng-hide="con.each_status =='Delivered' || con.dispatch_status == 'N' || view_ord.filter_status =='Cancelled'" data-target=".markas-{{parent_indexid}}-{{$index}}"> Mark as Delivered</button></div>





                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne-{{parent_indexid}}-{{$index}}" class="panel-collapse collapse in">

                                                            <div class="col-sm-7">
                                                                <p><span>Unloading Point</span> {{con.consignee_address}}
                                                                </p>
                                                            </div>
                                                            <div ng-if="view_ord.order_type !='Ex-work'" class="col-sm-5">
                                                                <p><span>Unloaders</span>
                                                                    <span ng-if="con.unloader_avb == 'Yes'">Available</span>
                                                                    <span ng-if="con.unloader_avb == 'No'">Unavailable</span> {{con.unloading_by}} </p>
                                                            </div>
                                                            <!--<span>Loading Date:</span> {{con.loading_date}} @ {{con.loading_hours}} : {{con.loading_minutes}}<br>
               
               <span>Loading Point:</span> 				   	   
					{{con.gate_number}} ,{{con.gate_list.address}} 
					{{con.gate_list.city}}, {{con.gate_list.state}} 
					{{con.gate_list.pincode}}, {{con.gate_list.country}}. 
					Region - {{con.gate_list.region}}					
				   <br>
               <span>Consignee Name:</span> {{con.consignee_name}}<br>
               <span>Unloading Point:</span> {{con.consignee_address}}<br>
               {{con.material_arr.length}} Materials <br>
              <span> Unloaders available:</span> {{con.unloader_avb}},
               <span>Paid by:</span> {{con.unloading_by}} </p>-->

                                                            <div class="">

                                                                <ul class="horizontal-bar" ng-if="view_ord.order_type !='Ex-work'">
                                                                    <li ng-class="{'active': con.truck_status == 'Y', 'nobar': con.arrived_status != 'Y'}"><span>Assigned <span class="date">{{con.truck_assigned_date}}</span></span>
                                                                    </li>
                                                                    <li ng-class="{'active': con.arriving_status == 'Y' || con.arrived_status == 'Y', 'nobar': con.arrived_status != 'Y'}"><span>Arriving <span class="date">{{con.arriving_date}}</span></span>
                                                                    </li>
                                                                    <li ng-class="{'active': con.arrived_status == 'Y', 'nobar': con.dispatch_status != 'Y'}"><span>Arrived <span class="date">{{con.arrived_date}}</span></span>
                                                                    </li>
                                                                    <li ng-class="{'active': con.dispatch_status == 'Y', 'nobar': con.delivery_status != 'D'}"><span>Dispatched <span class="date">{{con.dispatch_date}}</span></span>
                                                                    </li>
                                                                    <li ng-class="{'active': con.delivery_arriving_status == 'Y' || con.delivery_status == 'D', 'nobar': con.delivery_status != 'D'}"><span>Delivering <span class="date" ng-if="con.delivery_arriving_date !=''">{{con.delivery_arriving_date}}</span><span class="date" ng-if="con.delivery_arriving_date ==''">{{con.delivery_date}}</span></span>
                                                                    </li>
                                                                    <li ng-class="{'active': con.delivery_status == 'D'}"><span>Delivered <span class="date">{{con.POD_date}}</span></span>
                                                                    </li>
                                                                </ul>

                                                                <!--

			  <div class="horizontal-bar-sub" ng-if="con.arrived_status == 'Y'">
                
                <ul class="horizontal-bar-sub"><div class="timing"  ng-if="con.loading_end == 'Y'" style="display:inline-block">Loading time: <div ng-bind="con.loading_diff">Hours</div></div>
				<div class="timing" ng-if="con.loading_end == 'Y'">No Of Units dispatched : <div ng-bind="con.noofUnits">Hours</div></div>
                 <li ng-class="{'active': con.loading_started == 'Y', 'nobar': con.loading_end == 'N'}">
                  <div class="hori_text">
                   <a ng-if="con.loading_started == 'N'" href="javascript:;" ng-class="{'btn-disabled': con.dispatch_status == 'Y'}"  ng-disabled="con.dispatch_status == 'Y'" ng-click="loadingStarted(view_ord.order_id,key)" class="btn">Loading Started</a>
                   <span ng-if="con.loading_started == 'Y'" ng-bind="con.loading_time"></span>
                  </div>
                 </li>
                 <li ng-class="{'active': con.loading_end == 'Y'}">
                  <div class="hori_text">
                   <a href="javascript:;" ng-if="con.loading_end == 'N'" ng-class="{'btn-disabled': con.loading_started == 'N' || con.dispatch_status == 'Y'}"  ng-disabled="con.loading_started == 'N' || con.dispatch_status == 'Y'" class="btn" data-toggle="modal" data-target="#unit-disp-{{parent_indexid}}-{{$index}}">Loading Ended</a>
				   
				    <div class="modal fade small_modal" id="unit-disp-{{parent_indexid}}-{{$index}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Units</h4>
      </div>
      <div class="modal-body " style="padding:0px;">
	  <span ng-init="noofUnits = ''"></span>
        
		<div class="row">
                   <div class="form-group">
                    <div class="col-xs-5 col-sm-4 pad-right-0" style="font-size:13px;">No of units dispatched</div>
                    <div class="col-xs-2 col-sm-4 no-padding">
                     <input type="text" class="form-control" digit-only="" autocomplete="off" ng-model="noofUnits" id="noofUnits" placeholder="">
                    </div>
                    <div class="col-xs-5 col-sm-4"></div>
                   </div>
				   <div class="clearfix"></div>
				    <br>
				   <div class="text-center">        
        <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="loadingEnd(view_ord.order_id,key,noofUnits)" >Save</button>
      </div>
	  <div class="clearfix"></div>
	  <br>
                  </div>
		
      </div>
      
    </div>
  </div>
</div>
				   
				   
                   <span ng-if="con.loading_end == 'Y'" ng-bind="con.loading_end_time"></span>
                  </div>	
                 </li>
               </ul></div>	---->

                                                                <div class="order-truck-icons" ng-if="con.truck_status == 'Y'"><a href="" data-toggle="modal" data-target="#truck{{parent_indexid}}" class="icon-truck-order">Truck Details</a></div>
                                                                <!--<div class="order-truck-icons" ng-if="con.dispatch_status == 'Y'"><a href=""  data-toggle="modal" data-target="#gatem{{parent_indexid}}-{{$index}}" class="icon-truck-gp">Gate Pass</a></div>-->
                                                                <div class="order-truck-icons" ng-if="con.truck_status == 'Y'"><a href="" data-toggle="modal" data-target="#lr{{parent_indexid}}-{{$index}}" class="icon-truck-lr">LR Details</a></div>
                                                                <div class="order-truck-icons" ng-if="con.dispatch_status == 'Y'"><a href="<?php echo site_url();?>tracking/order/{{con.hypertracking_by}}/{{con.hyperconsignee_id}}" target="_blank" class="icon-truck-location">Truck Location</a></div>
                                                                <div class="order-truck-icons1" ng-if="con.delivery_status == 'D'" ng-class="{exworkproof: view_ord.order_type == 'Ex-work'}"><a href="" data-toggle="modal" data-target="#podm{{parent_indexid}}-{{$index}}" class="icon-truck-pod">Proof of Delivery</a></div>

                                                                <div class="clearfix"></div>
                                                                <div class="col-sm-12">

                                                                    <a href="#" data-toggle="modal" ng-if='view_ord.order_in != "Single"' data-target="#material_pop{{parent_indexid}}-{{$index}}" class="btn">Material Info</a>

                                                                    <div class="modal fade bs-example-modal-sm" id="Duplicate-{{parent_indexid}}-{{$index}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                                                        <div class="modal-dialog modal-sm" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title">These materials have already been added</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>{{duplicatematerial}} </p>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default" ng-click="emptyDuplicat(view_ord.order_id,$index,con.consignee_id)" data-dismiss="modal">Cancel</button>
                                                                                    <button type="button" class="btn btn-primary" ng-click="replaceDuplicat(view_ord.order_id,$index,con.consignee_id)">Replace </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <a data-target="#viewSLA{{parent_indexid}}-{{$index}}-0" ng-if="view_ord.order_type == 'Open'" data-toggle="modal" class="btn ">View SLA</a>
                                                                    <b ng-if="con.dispatch_status == 'Y'">&nbsp;Units Dispatched: {{con.noofUnits}}</b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<a href="#" data-toggle="modal" ng-if='view_ord.order_in != "Single"' data-target="#orderDetails{{parent_indexid}}-{{$index}}" class="btn">Order Details</a>-->


                                            <span ng-init="sla = con.sla_details"></span>



                                            <!-- modal setting start -->
                                            <div id="viewSLA{{parent_indexid}}-{{$index}}-0" ng-if="view_ord.order_type == 'Open'" class="modal fade " role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <header>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h1>SLA Settings</h1>

                                                            <div class="alert alert-danger pop_error_yes"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                            <div class="alert alert-success pop_error_no"><i class="fa fa-check-circle" aria-hidden="true"></i> {{uerr_msg}}</div>

                                                        </header>
                                                        <div class="modal-body">
                                                            <div class="panel-body login_body">
                                                                <ul class="nav nav-tabs">
                                                                    <li class="active"><a data-toggle="tab" href="#price{{parent_indexid}}-{{$index}}">Contracted Rates</a></li>
                                                                    <li><a data-toggle="tab" href="#time{{parent_indexid}}-{{$index}}">SLA Time</a></li>
                                                                </ul>
                                                                <div class="tab-content">
                                                                    <div id="price{{parent_indexid}}-{{$index}}" class="tab-pane fade in active"> <br>
                                                                        <div class="row">
                                                                            <div class="col-xs-5 col-sm-4 title"><span>Charge Type</span></div>
                                                                            <div class="col-xs-2 col-sm-4 no-padding title"><span>Amount</span></div>
                                                                            <div class="col-xs-5 col-sm-4 title"><span>Unit</span></div>
                                                                        </div>


                                                                        <div class="row" ng-if="sla.type =='Matrix'">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0"></div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    &nbsp;
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4">

                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Contracted Freight Charges</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.freight_charges" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4">
                                                                                    <select class="form-control" disabled ng-model="sla.freight_unit">
                       <option value="">Select type</option>
                       <option value="per_trip">Per Trip</option>
                       <option value="per_kg">Per Kg</option>
                       <option value="volumetric">Volumetric</option>
                     </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" ng-if="sla.freight_unit == 'per_kg' || sla.freight_unit == 'volumetric'">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Minimum Guarantee Rate</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.minimum_rate" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4"> </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" ng-if="sla.freight_unit == 'per_kg'">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Multiplying factor</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.multiplying_factor" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4"> </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Cancellation Charges</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.cancellation_charges" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Loading Detention Charges (Cumulative)</div>
                                                                                <div class="col-xs-2 col-sm-8 no-padding">
                                                                                    <!--- <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.detention_delay_charges" id="email" placeholder="">--->
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_1d" id="email" placeholder="Day 1">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_2d" id="email" placeholder="Day 2">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_3d" id="email" placeholder="Day 3">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_4d" id="email" placeholder="Day 4">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_5d" id="email" placeholder="Day 5">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddetention_6d" id="email" placeholder="> Day 5">
                                                                                </div>
                                                                                <!-- <div class="col-xs-5 col-sm-4">
                     <select class="form-control" ng-if="sla.type == 'Manual'" disabled ng-model="sla.detention_delay_unit">
                      <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>
                     <select class="form-control" ng-if="sla.type != 'Manual'" disabled ng-model="sla.detention_delay_unit">
                      <option value="">Per - day(Progressive)</option>
                     </select>
                    </div>--->
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Transit Delay Penalty (Cumulative)</div>
                                                                                <div class="col-xs-2 col-sm-8 no-padding">
                                                                                    <!--- <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.delivery_delay_charges" id="email" placeholder="">--->
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_1d" id="email" placeholder="Day 1">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_2d" id="email" placeholder="Day 2">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled disabled ng-model="sla.ddelivery_3d" id="email" placeholder="Day 3">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_4d" id="email" placeholder="Day 4">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_5d" id="email" placeholder="Day 5">
                                                                                    <input type="text" class="form-control days" digit-only autocomplete="off" disabled ng-model="sla.ddelivery_6d" id="email" placeholder="> Day 5">
                                                                                </div>
                                                                                <!--  <div class="col-xs-5 col-sm-4">
                     <select class="form-control" ng-if="sla.type == 'Manual'" disabled ng-model="sla.delivery_delay_unit">
                      <option value="">Select Hours</option>
                      <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>
                        
                      <select class="form-control" ng-if="sla.type != 'Manual'" disabled ng-model="sla.delivery_delay_unit">
                      <option value="">Per - day(Progressive)</option>
                     </select>  
                        
                    </div>---->
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Unloading Delay Charges (Cumulative)</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.arrival_delay_charges" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4">
                                                                                    <select class="form-control" ng-if="sla.type == 'Manual'" disabled ng-model="sla.arrival_delay_unit">
                      <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>

                                                                                    <select class="form-control" ng-if="sla.type != 'Manual'" disabled ng-model="sla.arrival_delay_unit">
                      <option value="">Per - day(Progressive)</option>
                     </select>

                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">LR Charges</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.lr_charge" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4"> </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Loading Charges</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.loading_charge" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4">
                                                                                    <select class="form-control" disabled ng-model="sla.loading_unit2">
                      <option value="">Select</option>
                      <option value="Per-KG">Per-KG</option>
                      <option value="Per-Order">Per-Order</option>
                     </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Unloading Charges</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only autocomplete="off" disabled ng-model="sla.unloading_charge" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4">
                                                                                    <select class="form-control" disabled ng-model="sla.unloading_unit2">
                      <option value="">Select</option>
                      <option value="Per-KG">Per-KG</option>
                      <option value="Per-Order">Per-Order</option>
                     </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                    <div id="time{{parent_indexid}}-{{$index}}" class="tab-pane fade"> <br>
                                                                        <div class="row">
                                                                            <div class="col-xs-5 col-sm-4 title"><span>Charge Type</span></div>
                                                                            <div class="col-xs-2 col-sm-4 no-padding title"><span ng-if="sla.type == 'Manual'">Value in hours</span><span ng-if="sla.type != 'Manual'">Value in days</span></div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Maximum Unloading Time Allowed</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only maxlength="2" autocomplete="off" disabled ng-model="sla.arrival_time" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4">
                                                                                    <!--  <select class="form-control" ng-model="sla.arrival_unit">
                       <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                       <option value="12">12</option>
                       <option value="24">24</option>
                     </select>-->

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Maximum Loading Time Allowed</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only maxlength="2" autocomplete="off" disabled ng-model="sla.loading_time" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4">

                                                                                    <!--  <select class="form-control" ng-model="sla.loading_unit">
                      <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>-->

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group">
                                                                                <div class="col-xs-5 col-sm-4 pad-right-0">Maximum Transit Time Allowed</div>
                                                                                <div class="col-xs-2 col-sm-4 no-padding">
                                                                                    <input type="text" class="form-control" digit-only maxlength="2" autocomplete="off" disabled ng-model="sla.transit_time" id="email" placeholder="">
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-4">

                                                                                    <!--    <select class="form-control" ng-model="sla.transit_unit">
                      <option value="">Select Hours</option>
                       <option value="1">1</option><option value="6">6</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                     </select>-->

                                                                                </div>
                                                                            </div>
                                                                        </div>







                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!--end login Form -->
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- modal setting ends -->



                                            <!-- Lr modal start here -->
                                            <div id="lr{{parent_indexid}}-{{$index}}" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <div class="modal-body">
                                                            <header>
                                                                <h1>LR Details</h1>
                                                            </header>
                                                            <div class="alert alert-danger pop_error_yes"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                            <div class="alert alert-success pop_error_no"><i class="fa fa-check-circle" aria-hidden="true"></i> {{uerr_msg}}</div>

                                                            <form name="podform" id="ordform" ng-submit="POD_form(podform.$valid,item);" ng-class="{'submitted': submitted}" novalidate="novalidate">
                                                                <div class="form-comm-pad">

                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <h4>Consignor Details</h4>
                                                                            <div class="form-group">
                                                                                <label><strong>Company Name</strong>:</label><br/> {{view_ord.plp_name}}
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label><strong>Address</strong>:</label><br/> {{view_ord.plp_address}}
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label><strong>Telephone Number</strong>:</label><br/> {{view_ord.PLP_phone}}
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <h4>Consignee details</h4>
                                                                            <div class="form-group">
                                                                                <label><strong>Company Name</strong>:</label><br/> {{con.consignee_name}}
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label><strong>Address</strong>:</label><br/> {{con.consignee_address}}
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label><strong>Telephone Number</strong>:</label><br/> {{con.office_phone}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <h4>Document Details</h4>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label>Invoice Number:</label>
                                                                                <input type="text" ng-model="con.invoice_number" required="" class="form-control" placeholder="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>STN Number:</label>
                                                                                <input type="text" ng-model="con.stn_number" required="" class="form-control" placeholder="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                Declaration<br>
                                                                                <div class="inputradio col-lg-6">
                                                                                    <input id="d-option{{parent_indexid}}-{{$index}}" ng-model="con.declaration" value="Standard" name="selector" type="radio">
                                                                                    <label for="d-option{{parent_indexid}}-{{$index}}">Standard</label>
                                                                                    <div class="check"></div>
                                                                                </div>
                                                                                <div class="inputradio col-lg-6">
                                                                                    <input id="e-option{{parent_indexid}}-{{$index}}" ng-model="con.declaration" value="Premium" name="selector" type="radio">
                                                                                    <label for="e-option{{parent_indexid}}-{{$index}}">Premium</label>
                                                                                    <div class="check"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label>Form/Permit Number:</label>
                                                                                <input type="text" ng-model="con.permit_number" required="" class="form-control" placeholder="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Consignment Note Number:</label>
                                                                                <input type="text" ng-model="con.consign_note_no" required="" class="form-control" placeholder="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <h4>Proof Of Delivery</h4>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label>Date & Time:</label>
                                                                                <input type="text" ng-model="con.POD_date" class="form-control" placeholder="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Received by:</label>
                                                                                <input type="text" ng-model="con.pod_received_by" required="" class="form-control" placeholder="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label>Reference Number:</label>
                                                                                <input type="text" ng-model="con.pod_reference_no" class="form-control" placeholder="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group"><br>
                                                                        <a href="<?php echo site_url();?>tracking/lrdetails/{{view_ord.order_id}}/{{con.tracking_by}}" target="_blank" class="btn col-sm-12">View Original LR Form</a></div>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            <div class="col-sm-3"><span>LR No:</span></div>
                                                                            <div class="col-sm-9"><span> {{con.lr_no}} </span></div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="col-sm-3"><span>LR file:</span></div>
                                                                            <div class="col-sm-9"><span> <a href="{{con.lr_file}}" ng-if="con.lr_file !=''" target="_blank">Click here to view LR File</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group btn-padding text-right">
                                                                        <div class="col-sm-12">
                                                                            <input class="btn btn-cancel" data-dismiss="modal" value="Cancel" type="submit">
                                                                            <input class="btn" value="Submit" class="btn" ng-click="submitted= true;" type="submit">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!--end login Form -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Lr modal ends here -->


                                            <!-- Modal start here -->
                                            <div id="orderDetails{{parent_indexid}}-{{$index}}" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                        <!-- Consignee start here -->
                                                        <div class="modal-body truck">
                                                            <div class="row">
                                                                <header>
                                                                    <h1>Consignment {{$index + 1}}</h1>
                                                                </header>
                                                            </div>

                                                            <div class="alert alert-danger pop_error_yes"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                            <div class="alert alert-success pop_error_no"><i class="fa fa-check-circle" aria-hidden="true"></i> {{uerr_msg}}</div>

                                                            <div class="order-content-status">
                                                                <div class="col-sm-12">
                                                                    <h4>Consignment Status</h4>
                                                                </div>
                                                                <br>
                                                                <div>
                                                                    <ul class="horizontal-bar">
                                                                        <li class="assigned" ng-class="{'active': con.truck_status == 'Y'}"><span><i>Truck Assigned</i><br>
            <span ng-if="con.truck_status == 'Y'" ng-bind="con.truck_assigned_date"></span>
                                                                            </span>
                                                                            <div class="col-xs-12 no-padding"><a href="#" ng-click="truck_show(parent_indexid ,$index)" class="btn truckDetails">Truck Details</a>
                                                                                <a href="#" data-toggle="modal" data-target="#lr{{parent_indexid}}-{{$index}}" class="btn lrDetails">LR Details</a>
                                                                            </div>
                                                                            <!-- Lr modal start here -->
                                                                            <div id="lr{{parent_indexid}}-{{$index}}" class="modal fade" role="dialog">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        <div class="modal-body">
                                                                                            <header>
                                                                                                <h1>LR Details</h1>
                                                                                            </header>
                                                                                            <div class="alert alert-danger pop_error_yes"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                                                            <div class="alert alert-success pop_error_no"><i class="fa fa-check-circle" aria-hidden="true"></i> {{uerr_msg}}</div>

                                                                                            <form name="podform" id="ordform" ng-submit="POD_form(podform.$valid,item);" ng-class="{'submitted': submitted}" novalidate="novalidate">
                                                                                                <div class="form-comm-pad">

                                                                                                    <div class="row">
                                                                                                        <div class="col-lg-6">
                                                                                                            <h4>Consignor Details</h4>
                                                                                                            <div class="form-group">
                                                                                                                <label><strong>Company Name</strong>:</label><br/> {{view_ord.plp_name}}
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label><strong>Address</strong>:</label><br/> {{view_ord.plp_address}}
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label><strong>Telephone Number</strong>:</label><br/> {{view_ord.PLP_phone}}
                                                                                                            </div>

                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <h4>Consignee details</h4>
                                                                                                            <div class="form-group">
                                                                                                                <label><strong>Company Name</strong>:</label><br/> {{con.consignee_name}}
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label><strong>Address</strong>:</label><br/> {{con.consignee_address}}
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label><strong>Telephone Number</strong>:</label><br/> {{con.office_phone}}
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <h4>Document Details</h4>
                                                                                                        </div>
                                                                                                        <div class="col-sm-6">
                                                                                                            <div class="form-group">
                                                                                                                <label>Invoice Number:</label>
                                                                                                                <input type="text" ng-model="con.invoice_number" required="" class="form-control" placeholder="">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label>STN Number:</label>
                                                                                                                <input type="text" ng-model="con.stn_number" required="" class="form-control" placeholder="">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                Declaration<br>
                                                                                                                <div class="inputradio col-lg-6">
                                                                                                                    <input id="d-option{{parent_indexid}}-{{$index}}" ng-model="con.declaration" name="selector" type="radio">
                                                                                                                    <label for="d-option{{parent_indexid}}-{{$index}}">Standard</label>
                                                                                                                    <div class="check"></div>
                                                                                                                </div>
                                                                                                                <div class="inputradio col-lg-6">
                                                                                                                    <input id="e-option{{parent_indexid}}-{{$index}}" ng-model="con.declaration" name="selector" type="radio">
                                                                                                                    <label for="e-option{{parent_indexid}}-{{$index}}">Premium</label>
                                                                                                                    <div class="check"></div>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>

                                                                                                        <div class="col-sm-6">
                                                                                                            <div class="form-group">
                                                                                                                <label>Form/Permit Number:</label>
                                                                                                                <input type="text" ng-model="con.permit_number" required="" class="form-control" placeholder="">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label>Consignment Note Number:</label>
                                                                                                                <input type="text" ng-model="con.consign_note_no" required="" class="form-control" placeholder="">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <h4>Proof Of Delivery</h4>
                                                                                                        </div>
                                                                                                        <div class="col-sm-6">
                                                                                                            <div class="form-group">
                                                                                                                <label>Date & Time:</label>
                                                                                                                <input type="text" ng-model="con.POD_date" class="form-control" placeholder="">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label>Received by:</label>
                                                                                                                <input type="text" ng-model="con.pod_received_by" required="" class="form-control" placeholder="">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-sm-6">
                                                                                                            <div class="form-group">
                                                                                                                <label>Reference Number:</label>
                                                                                                                <input type="text" ng-model="con.pod_reference_no" class="form-control" placeholder="">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group"><br>
                                                                                                        <a href="<?php echo site_url();?>tracking/lrdetails/{{view_ord.order_id}}/{{con.tracking_by}}" target="_blank" class="btn col-sm-12">View Original LR Form</a></div>

                                                                                                    <div class="form-group">
                                                                                                        <div class="col-sm-6">
                                                                                                            <div class="col-sm-3"><span>LR No:</span></div>
                                                                                                            <div class="col-sm-9"><span> {{con.lr_no}} </span></div>
                                                                                                        </div>
                                                                                                        <div class="col-sm-6">
                                                                                                            <div class="col-sm-3"><span>LR file:</span></div>
                                                                                                            <div class="col-sm-9"><span> <a href="{{con.lr_file}}" ng-if="con.lr_file !=''" target="_blank">Click here to view LR File</span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="form-group btn-padding text-right">
                                                                                                        <div class="col-sm-12">
                                                                                                            <input class="btn btn-cancel" data-dismiss="modal" value="Cancel" type="submit">
                                                                                                            <input class="btn" value="Submit" class="btn" ng-click="submitted= true;" type="submit">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                        <!--end login Form -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Lr modal ends here -->
                                                                        </li>
                                                                        <li class="arrived" ng-class="{'active': con.arrived_status == 'Y'}"><span><i>Arrived</i><br>
            <span ng-if="con.arrived_status == 'Y'" ng-bind="con.arrived_date"></span></span>
                                                                            <div class="col-xs-12 no-padding" ng-if="con.dispatch_status == 'Y'"><a href="#" class="btn">Gate Pass </a></div>
                                                                        </li>
                                                                        <li class="dispatched" ng-class="{'active': con.dispatch_status == 'Y'}"><span><i>Dispatched</i><br>
            <span ng-if="con.dispatch_status == 'Y'" ng-bind="con.dispatch_date"></span>
                                                                            </span>
                                                                            <!--<div class="col-xs-12 no-padding"><a href="<?php echo site_url();?>tracking/order/{{con.hypertracking_by}}/{{con.hyperconsignee_id}}" target="_blank" class="btn">View truck location</a></div>-->
                                                                        </li>
                                                                        <li class="completed" ng-class="{'active': con.delivery_status == 'D'}">

                                                                            <span><i>Completed</i><br>
			 <span ng-if="con.delivery_status == 'D'" ng-bind="con.POD_date"></span>
                                                                            </span>
                                                                            <div ng-if="con.delivery_status == 'D'" class="col-xs-12 no-padding"><a href="<?php echo site_url()." assets/uploads/pod/ "; ?>{{con.POD_file}}" class="btn">Proof of Delivery  {{con.delivery_status}} </a></div>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="order-content-status bdr">
                                                                    <div class="col-sm-12">
                                                                        <h4>Consignment Details</h4><span>Consignee Name:</span>
                                                                        <p class="consignment-det" ng-bind='con.consignee_name'></p>
                                                                        <span>Unloading Point</span>
                                                                        <p class="consignment-det" ng-bind='con.consignee_address'></p>
                                                                        <div class="clearfix"></div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- !Consignee ends here -->

                                                        <!-- Truck start here -->
                                                        <div class="modal-body truck_show" style="display: none">
                                                            <div class="popup-truck-bg" style='background-image: url("{{view_ord.vehicle_photo}}");'>
                                                            </div>
                                                            <div class="panel-body login_body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <a href="#" id="back_order" ng-click="Back_order(parent_indexid ,$index)">Back to Order Details</a>
                                                                        <h1>Truck Details</h1>
                                                                    </div>
                                                                </div>
                                                                <div class="row" ng-repeat="vch in view_ord.vehicle">
                                                                    <div class="col-sm-6"><span>Truck Number</span> {{vch.frm_truckno}}<br>
                                                                        <br>
                                                                        <span>Make</span> {{vch.frm_make}}<br>
                                                                        <br>
                                                                        <span>Insurance</span> Valid till {{vch.frm_insurance_validtill}}<br>

                                                                    </div>
                                                                    <div class="col-sm-6"><span>Truck Type</span> {{vch.frm_trucktype}}<br>
                                                                        <br>
                                                                        <span>Model</span> {{vch.frm_model}}<br>
                                                                        <br>
                                                                        <span>Fitness Certificate</span>Valid till {{vch.frm_fitness_certivalidtill}}<br>
                                                                    </div>
                                                                </div>

                                                                <div class="row driver-img"><img ng-src="{{view_ord.frm_driverimg}}" width="92" height="91" alt="" /></div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h1>Driver Details</h1>
                                                                    </div>
                                                                </div>
                                                                <div class="row" ng-repeat="drv in view_ord.driver">
                                                                    <div class="col-sm-6"> <span>Driver Name</span> {{drv.frm_drivername}}<br>
                                                                        <br>
                                                                        <span>Mobile Nunber</span> {{drv.frm_phoneno}}<span></span> </div>
                                                                    <div class="col-sm-6"><span>License</span> {{drv.frm_driverlno}}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Truck ends here -->



                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 flex-item ordered-details no-padding flex-grey">

                                <!--ng-if='view_ord.order_in == "Single"'--->
                                <div class="col-sm-12">
                                    <div ng-hide="(view_ord.order_type == 'Ex-work' && view_ord.login_type != 'PA') || (view_ord.order_type == 'Open' && view_ord.login_type == 'SA') || (view_ord.login_type == 'PA' && view_ord.requestStatus == 'A')">
                                        <a href="{{view_ord.edit_url}}" ng-hide=" (view_ord.order_type == 'Open' && view_ord.order_by == 'SA' && view_ord.login_type == 'PA') ||   view_ord.filter_status !='Intended' || view_ord.filter_status =='Cancelled'" class="btn btn-info">Edit Order</a>
                                    </div>
                                    <a href="javascript:;" ng-click="acceptSLA(view_ord.order_id,parent_indexid)" ng-show=" ((view_ord.login_type == 'AD') && view_ord.requestStatus == 'P')" class="btn btn-info btn-next">Accept</a>

                                    <!-- Material start here -->

                                    <div class="material_sec">
                                        <a href="#" class="btn" data-target="#material_pop{{parent_indexid}}-0" ng-if='view_ord.order_in == "Single"' data-toggle="modal">Material Info</a>

                                    </div>

                                    <!-- Material ends here -->

                                    <div class="truckAssidn" ng-if="view_ord.order_type !='Ex-work'">
                                        <a href="#" class="btn btn-info " data-target="#truckAssign{{parent_indexid}}-0" ng-show="view_ord.order_type != 'Open'" ng-if=" view_ord.consignee[0].truck_status !='Y' &&  view_ord.login_type == 'PA'" data-toggle="modal">Assign Truck</a>
                                        <a href="#" class="btn btn-info " data-target="#truckAssign{{parent_indexid}}-0" ng-show="view_ord.order_type == 'Open' && view_ord.requestStatus == 'A'" ng-if=" view_ord.consignee[0].truck_status !='Y' &&  view_ord.login_type == 'PA'" data-toggle="modal">Assign Truck</a>



                                        <div id="truckAssign{{parent_indexid}}-0" class="modal fade" role="dialog">


                                            <form name="truckForm" id="truckForm-{{parent_indexid}}" ng-submit="truckAssign(truckForm.$valid,view_ord.order_id,truck,driver,parent_indexid);" ng-class="{'submitted': submitted}" novalidate="novalidate">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <div class="modal-header">
                                                            <h1>Assign Truck</h1>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="alert alert-danger pop_error_yes-{{parent_indexid}}"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                            <div class="alert alert-success pop_error_no-{{parent_indexid}}"><i class="fa fa-check-circle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                            <div class="alert alert-warning pop_error_wait-{{parent_indexid}}" style="display:none;">{{uerr_msg}}</div>
                                                            <div class="clearfix"></div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="alert alert-danger pop_error_yes"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                                    <div class="alert alert-success pop_error_no"><i class="fa fa-check-circle" aria-hidden="true"></i> {{uerr_msg}}</div>
                                                                    <div class="form-comm-pad">
                                                                        <h4>Truck Details</h4>
                                                                        <span ng-init="truck.truckMode = 4"></span>
                                                                        <div class="col-sm-6"><label>Truck Number *</label>
                                                                            <div class="form-group">
                                                                                <div class="inputradio">
                                                                                    <input type="radio" id="truckMode4" name="truckMode" ng-model="truck.truckMode" value="4" />
                                                                                    <label for="truckMode4">
               
						<!--<input ng-model="truck.number" ng-pattern="/^[A-Z]{2}[ -][0-9A-Z]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/" placeholder="XX 99/XX XX 9999" required class="form-control">-->
						<!--<input ng-model="truck.number" ng-pattern="/^[A-Z]{2}[ -][0-9A-Z]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/" placeholder="XX 99/XX XX 9999" required class="form-control">-->
						<input ng-model="truck.one" ng-keyup="changeTocaps()"  placeholder="XX" ng-required="truck.truckMode == 4" ng-pattern="/^[A-Z]{2}$/" ng-disabled="truck.truckMode == 3"   class="form-control time" maxlength="2" truckno class="form-control">
						<input ng-model="truck.two" placeholder="99/XX" ng-required="truck.truckMode == 4" ng-pattern="/^[0-9A-Z]{1,2}$/" ng-disabled="truck.truckMode == 3"  class="form-control time" maxlength="2" truckno class="form-control">
						<input ng-model="truck.three"   placeholder="XX" ng-required="truck.truckMode == 4" ng-pattern="/^[0-9A-Z]{1,4}$/" ng-disabled="truck.truckMode == 3"  class="form-control days" maxlength="4" truckno class="form-control">
						<input ng-model="truck.four"   placeholder="9999" ng-required="truck.truckMode == 4" ng-pattern="/^[0-9]{4}$/" ng-disabled="truck.truckMode == 3"  class="form-control days" maxlength="4"  class="form-control">
      </label>
                                                                                    <div class="check"></div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <div class="inputradio" style="margin-top:10px;">
                                                                                    <input type="radio" id="truckMode3" name="truckMode" ng-model="truck.truckMode" value="3" />
                                                                                    <label for="truckMode3">
						<!--<input ng-model="truck.number" ng-pattern="/^[A-Z]{2}[ -][0-9A-Z]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/" placeholder="XX 99/XX XX 9999" required class="form-control">-->
						<!--<input ng-model="truck.number" ng-pattern="/^[A-Z]{2}[ -][0-9A-Z]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/" placeholder="XX 99/XX XX 9999" required class="form-control">-->
						<input ng-model="truck.sec_one"   placeholder="XXX" ng-required="truck.truckMode == 3"  ng-pattern="/^[A-Z]{3}$/" ng-disabled="truck.truckMode == 4" class="form-control days" maxlength="3" truckno class="form-control">
						<input ng-model="truck.sec_two" placeholder="9999"  ng-required="truck.truckMode == 3" ng-pattern="/^[0-9]{4}$/" ng-disabled="truck.truckMode == 4" class="form-control days"  maxlength="4" truckno class="form-control">
      </label>
                                                                                    <div class="check"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <span ng-show="truck.number.$error.pattern">Not a valid number!</span>
                                                                        <div class="col-sm-6"><label>Truck Type</label>
                                                                            <div class="form-group">
                                                                                <div ng-bind="view_ord.vehicle_name"></div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="clearfix"></div>
                                                                        <div class="col-sm-6"><label>Make</label>
                                                                            <div class="form-group"><input ng-model="truck.make" class="form-control"></div>
                                                                        </div>
                                                                        <div class="col-sm-6"><label>Model</label>
                                                                            <div class="form-group"><input ng-model="truck.model" class="form-control"></div>
                                                                        </div>
                                                                        <div class="col-sm-6"><label>Insurance valid till</label>

                                                                            <div class="form-group"><input type="text" ng-model="truck.insuranace" datepicker class="form-control datefield datepicker"></div>
                                                                        </div>
                                                                        <div class="col-sm-6"><label>Fitness Certificate valid till</label>
                                                                            <div class="form-group"><input type="text" ng-model="truck.fitness" datepicker class="form-control datefield datepicker"></div>
                                                                        </div>
                                                                    </div>



                                                                    <div class="form-comm-pad bdr">
                                                                        <h4>Driver Details</h4>
                                                                        <div class="col-sm-6"><label>Driver Name </label>
                                                                            <div class="form-group"><input ng-model="driver.name" class="form-control"></div>
                                                                        </div>
                                                                        <div class="col-sm-6"><label>Driver's License Number</label>
                                                                            <div class="form-group"><input ng-model="driver.lincenseno" class="form-control"></div>
                                                                        </div>
                                                                        <div class="col-sm-6"><label>Driver's Phone Number *</label>
                                                                            <div class="form-group"><input ng-model="driver.phone" digit-only maxlength="10" required ng-pattern="/^[0-9]{10,10}$/" class="form-control"></div>
                                                                        </div>

                                                                    </div>



                                                                    <div class="form-group btn-padding text-right">
                                                                        <div class="col-sm-12">
                                                                            <input class="btn" value="Assign Truck" class="btn" ng-click="submitted= true;" ng-disabled="enableDisable" ng-hide="hideit" type="submit">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                                <!--  <div class=""><a href="javascript:void(0)" ng-hide="view_ord.filter_status =='Delivered' || view_ord.filter_status =='Cancelled' || view_ord.filter_status =='Intended'" ng-click="deliveryStatus(view_ord.order_id);"  class="btn btn-info">Mark as Delivered</a></div>-->
                                <div class="col-sm-12">
                                    <div ng-if="view_ord.order_type !='Ex-work'">
                                        <span>Loading Point</span>
                                        <p>{{view_ord.plp_address}}</p>
                                        <br>
                                        <span>Loading Date</span>
                                        <div ng-bind="view_ord.consignee[0].loading_date"></div>
                                        <div ng-bind="view_ord.consignee[0].loading_hours + ':'+ view_ord.consignee[0].loading_minutes "></div>
                                        <span>Loaders Available</span>

                                        <div class="order_values" ng-bind="view_ord.loader_avb"></div>


                                        <p ng-bind="view_ord.loading_by"></p>

                                        <br>





                                        <!--<div>
			<p>
			{{con.gate_number}},
			{{con.gate_list.address}}<br>
			{{con.gate_list.city}}, {{con.gate_list.state}}<br>
			{{con.gate_list.pincode}}, {{con.gate_list.country}}<br>
			Region - {{con.gate_list.region}}<br>
			
			</p>
		   </div>
		   
		   <span>Unloading Point</span>
            <p ng-bind="con.consignee_address"></p>
             
            <span>Unloaders available</span>
            <p ng-bind="con.unloader_avb"></p>
<span>Loading Date and Time</span>
           <p>{{con.loading_date}} @ {{con.loading_hours}} : {{con.loading_minutes}}</p>
           <span>Expected Delivery Date</span>
           <p ng-bind="con.expected_delivery">--</p>
           <span>Unloading Paid by</span>
           <p ng-bind="con.unloading_by"></p>
           
           
           --->







                                    </div>



                                    <span>Other Information : <button ng-hide="view_ord.filter_status =='Delivered'  || view_ord.filter_status =='Cancelled'" ng-if="view_ord.other_infoedit == false" class="editLr-no btn-read " ng-click="view_ord.other_infoedit = !view_ord.other_infoedit" style="text-decoration:underline;background:none; border:0; font-size:12px;" >Edit</button></span>
                                    <p ng-if="view_ord.other_infoedit == false" ng-bind="view_ord.other_information"></p>
                                    <p ng-if="view_ord.other_infoedit == true">

                                        <input type="text" required="" class="form-control edit" ng-model="view_ord.other_information" id="exampleInputEmail2" placeholder="">
                                        <button type="button" ng-click="updateOtherInfo(view_ord.order_id)" class="btn btn-lr">Save</button>
                                    </p>
                                    <div ng-if="view_ord.order_type !='Ex-work'">
                                        <span ng-if="view_ord.other_vehicle_req !=''">Other requirements:</span>
                                        <p ng-bind="view_ord.other_vehicle_req"></p>
                                    </div>
                                </div>
                                <!--<span>Order ID: </span>
           <p ng-bind="view_ord.order_ref"></p>
          <span>Created : </span>
           <p ng-bind="view_ord.created_date"></p>
           <span>Order Type : </span>
           <p> Contract</p>
           <span>Delivery Type : </span>
           <p ng-bind="view_ord.delivery_type"></p>
           <span>Vehicle Type: </span>
           <p ng-bind="view_ord.vehicle_name"></p>
           
           <span ng-if="view_ord.other_vehicle_req !=''">Other Vehicle requirements:</span>
           <p ng-bind="view_ord.other_vehicle_req"></p>
           
           
           <span>Loaders Available : </span>
           <p ng-bind="view_ord.loader_avb"></p></div>
           
          
           
           <div class="col-sm-6 col-lg-12">
           <span>Loaders Paid by : </span>
           <p ng-bind="view_ord.loading_by"> Transporter</p>
           
           
           <span ng-if="view_ord.other_information !=''">Other Information : </span>
           <p ng-bind="view_ord.other_information"></p>
		   
		   ng-hide="view_ord.order_type == 'Open' && view_ord.login_type == 'SA'"
		   -->
                                <div class="col-sm-12">
                                    <a ng-if="view_ord.order_type !='Ex-work'" href="{{view_ord.freight_division}}" target="_blank" class="btn btn-info" style="width:82%">Freight Workings</a>
                                    <a ng-if="view_ord.order_type !='Ex-work'" ng-hide="view_ord.filter_status !='Delivered'" href="{{view_ord.billing_url}}" target="_blank" style="float: right;padding-top: 10px;padding-left: 2px;"><img src='<?php echo site_url()."assets/images/invoice.png";?>' /></a>
                                    <div ng-if="view_ord.filter_status =='Assigned' || view_ord.filter_status == 'Arrived'">
                                        <span ng-init="gateID = view_ord.consignee[0].gate_list.gate_id"></span>
                                        <span ng-init="truckinStatus = view_ord.consignee[0].arrived_status"></span>
                                        <span ng-init="truckoutStatus = view_ord.consignee[0].dispatch_status"></span>

                                        <a href="javascript:;" ng-if="view_ord.consignee[0].arrived_status == 'N'" data-toggle="modal" data-target="#truck_in-{{parent_indexid}}" class="btn btn-truck-in order-truckin">Truck In</a>

                                        <!-- ng-click="truckin(view_ord.order_id,gateID,parent_indexid)"-->
                                        <div id="truck_in-{{parent_indexid}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <div class="modal-body">
                                                        <div class="col-sm-12 col-lg-12 no-padding">
                                                            <header>
                                                                <h1>Truck In</h1>
                                                            </header>
                                                            <div class="form-comm-pad">
                                                                <form class="form-horizontal" name="conformCon" id="conform" ng-submit="truckin(view_ord.order_id,gateID,parent_indexid,arrived_date,arrived_hours,arrived_minutes);" ng-class="{'submitted': con_submitted}" novalidate="novalidate">
                                                                    <div class="col-sm-12">
                                                                        <span ng-init="arrived_date = '<?php echo date('d/m/Y'); ?>'; arrived_hours = '<?php echo date('H'); ?>'; arrived_minutes ='<?php echo date('i'); ?>'"></span>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-6 col-lg-6" for="email">Truck In Date<i class="txt-red">*</i> :</label>
                                                                            <div class="col-sm-6 col-lg-6">
                                                                                <input type="text" name="expected_delivery" value="" readonly="" ng-model="arrived_date" required datepicker class="form-control  datefield">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-6 col-lg-6" for="email">Truck In Hours & Minutes  <i class="txt-red">*</i> :</label>
                                                                            <div class="col-sm-3 col-lg-3">
                                                                                <select ng-model="arrived_hours" class="form-control time"><option value="">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
                                                                            </div>
                                                                            <div class="col-sm-3 col-lg-3">
                                                                                <select ng-model="arrived_minutes" class="form-control time"><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 text-right">
                                                                            <input class="btn" value="Submit" ng-disabled="conformCon.$invalid" ng-click="con_submitted= true;" ng-hide="hideit" type="submit">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div ng-if="view_ord.loading_end == 'Y'">
                                        <span>Loading Time: </span>
                                        <p ng-bind="view_ord.loading_diff"></p>
                                    </div>

                                    <div ng-if="view_ord.consignee[0].arrived_status == 'Y'">
                                        <a href="javascript:;" ng-if="view_ord.loading_started == 'N'" ng-click="loading_started(view_ord.order_id)" ng-disabled="view_ord.consignee[0].dispatch_status == 'Y'" class="btn load_start order-truckout">Loading started</a>

                                        <a href="javascript:;" ng-if="view_ord.loading_end == 'N'" ng-click="loading_ends(view_ord.order_id)" ng-disabled="view_ord.loading_started == 'N' || view_ord.consignee[0].dispatch_status == 'Y'" class="btn load_end order-truckout">Loading Ended</a>
                                    </div>


                                    <div ng-if="view_ord.filter_status =='Assigned' || view_ord.filter_status == 'Arrived'">
                                        <span ng-init="gateID = view_ord.consignee[0].gate_list.gate_id"></span>
                                        <span ng-init="truckinStatus = view_ord.consignee[0].arrived_status"></span>
                                        <span ng-init="truckoutStatus = view_ord.consignee[0].dispatch_status"></span>
                                        <div class="text-danger" ng-if="view_ord.truckOut == false">LR number is missing for some Consignees.<br/></div>
                                        <a href="javascript:;" ng-if="view_ord.consignee[0].dispatch_status == 'N'" data-toggle="modal" data-target="#truck_out-{{parent_indexid}}" ng-disabled="view_ord.consignee[0].arrived_status != 'Y' || view_ord.truckOut != true || view_ord.loading_end == 'N'" class="btn btn-truck-in order-truckout">Truck Out</a>

                                        <!--ng-click="truckout(view_ord.order_id,gateID,parent_indexid)" -->
                                        <div id="truck_out-{{parent_indexid}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <div class="modal-body">
                                                        <div class="col-sm-12 col-lg-12 no-padding">
                                                            <header>
                                                                <h1>Truck Out</h1>
                                                            </header>
                                                            <span id="truck_err" style="display: none" class="alert alert-danger">{{truck_err}}</span>
                                                            <span ng-init="consigneeUnit = [];"></span>
                                                            <div class="form-comm-pad">
                                                                <form class="form-horizontal" name="conformCon" id="conform" ng-submit="truckout(view_ord.order_id,gateID,parent_indexid,arrived_date,arrived_hours,arrived_minutes,view_ord.consignee);" ng-class="{'submitted': con_submitted}" novalidate="novalidate">
                                                                    <div class="col-sm-12">

                                                                        <div class="form-group" ng-repeat="(key,con) in view_ord.consignee">
                                                                            <label class="col-sm-6 col-lg-6" for="email"><strong> # of units dispatched to {{con.consignee_name}}</strong> <i class="txt-red">*</i></label>
                                                                            <div class="col-sm-3 col-lg-3">

                                                                                <input type="text" name="expected_delivery" ng-model="con.noofUnits" required class="form-control  onlyInt"> <i></i>
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label class="col-sm-6 col-lg-6" for="email">Truck Out Date<i class="txt-red">*</i> :</label>
                                                                            <div class="col-sm-6 col-lg-6">
                                                                                <span ng-init="arrived_date = '<?php echo date('d/m/Y'); ?>'; arrived_hours = '<?php echo date('H'); ?>'; arrived_minutes ='<?php echo date('i'); ?>'"></span>
                                                                                <input type="text" name="expected_delivery" ng-change="Check_Truckdate(arrived_date)" readonly="" ng-model="arrived_date" required datepicker class="form-control  datefield">
                                                                            </div>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label class="col-sm-6 col-lg-6" for="email">Truck Out Hours & Minutes  <i class="txt-red">*</i> :</label>
                                                                            <div class="col-sm-3 col-lg-3">
                                                                                <select ng-model="arrived_hours" class="form-control time"><option value="">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
                                                                            </div>
                                                                            <div class="col-sm-3 col-lg-3">
                                                                                <select ng-model="arrived_minutes" class="form-control time"><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 text-right">
                                                                            <input class="btn" value="Submit" ng-disabled="conformCon.$invalid" ng-click="con_submitted= true;" ng-hide="hideit" type="submit">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div ng-show="view_ord.filter_status =='Intended' || view_ord.filter_status =='Assigned' || view_ord.filter_status == 'Arrived'"><a href="javascript:void(0)" data-target="#cancel_order-{{view_ord.order_id}}" data-toggle="modal" ng-disabled="view_ord.filter_status =='Delivered'" ng-hide="show" class="btn-info-cancel">Cancel Order</a></div>
                                </div>


                                <div id="cancel_order-{{view_ord.order_id}}" class="modal fade small_modal" role="dialog">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12 text-center">

                                                    </div>
                                                    <div class="col-sm-12">
                                                        <h4 class="text-center">Are you sure you want to cancel your Order.</h4><br>
                                                        <p>Cancellation charges : Rs. <input type="number" class="form-control onlyInt" ng-disabled="view_ord.gendBill == false" ng-model="view_ord.cancellation_charges" /></p>
                                                        <div class="" ng-init="view_ord.gendBill = false">

                                                            <div class="label-fields">
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="tarpaulin" ng-model="view_ord.gendBill" value="N" name="check1">
                                                                    <label for="tarpaulin"><span></span>Generate Bill</label>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br>
                                                        <div class="col-xs-12">
                                                            <div class="col-xs-6 text-center"><a ng-click="Cancel_order(view_ord.order_id,view_ord.cancellation_charges,view_ord.gendBill); show = !show" href="javascript:;" class="btn">Yes</a></div>
                                                            <div class="col-xs-6 text-center"> <a href="#" class="btn">No</a> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php if($this->session->flashdata('successCreated')) { ?>
<script>
    $(document).ready(function() {
        $('.popsesssion').show().fadeIn().delay(3000).fadeOut();
        $('#error_no_pop').modal();
    });

</script>
<?php //echo "SSSS"; ?>
<!--<div class="alert alert-success popsesssion" id="error_no" ><i class="fa fa-check-circle" aria-hidden="true"></i> Order created successfully</div>-->
<div id="error_no_pop" class="modal fade small_modal" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <div class="panel-body login_body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img src="<?php echo base_url();?>assets/images/order_created.png" width="128" height="111" alt="" /> <br>
                            <br>
                        </div>
                        <div class="col-sm-12">
                            <h1>Your Order has been created.</h1>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script>
    $(document).ready(function() {


        $(document).on('keydown', '.onlyInt', function(e) {

            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        $('ul.horizontal-bar li.active:after:last').css('border', '1px solid red');



    })

</script>
