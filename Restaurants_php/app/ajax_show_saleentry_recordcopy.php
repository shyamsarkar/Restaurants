<div class="row">
            <div class="col s12">
               <?php
                for ($i=0; $i < 5; $i++) { 
               ?>
               <div class="card horizontal">
                  <div class="card-image">
                     <label style="padding:10px;line-height:10;">
                        <input type="checkbox" class="filled-in" checked="checked" />
                        <span style="z-index: 0;"><?php echo $i; ?></span>
                     </label>
                  </div>
                  <div class="card-stacked">
                     <div class="card-content" style="padding: 10px 10px 0px;">
                        <div class="row" style="margin-bottom: 5px;">
                           <div class="col s6">
                              <span class="grey-text">Bill No.:- </span>
                              <span>11111</span>
                           </div>
                           <div class="col s6">
                              <span class="grey-text">Bill Amt:- </span>
                              <span>55555</span>
                           </div>
                           <div class="col s6">
                              <span class="grey-text">Date:- </span>
                              <span>11111</span>
                           </div>
                           <div class="col s6">
                              <span class="grey-text">Paid Amt:- </span>
                              <span>555555</span>
                           </div>
                        </div>
                        <div class="row" style="margin-bottom: 0px;">
                           <div class="input-field col s6">
                              <label for="">Recieved Amount</label>
                              <input type="text" name="" id="" placeholder="000000" style="height: 2rem;">
                           </div>
                           <div class="input-field col s6">
                              <label for="">Discount Amount</label>
                              <input type="text" name="" id="" placeholder="000000" style="height: 2rem;">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <?php }
               ?>
               
            </div>
         </div>