<!DOCTYPE html>
<html>
<title>Order Invoice</title>
<head>
<link rel="shortcut icon" href="{{url('images/favicon.svg')}}" type="image/x-icon">
<link rel="icon" href="{{url('images/favicon.svg')}}" type="image/x-icon">

<style>
@page {
    margin: 10px 20px 10px 20px;
}
table, th, td {
    border: 0.5pt solid #0070C0;
    border-collapse: collapse;   

}
th, td {
    /*padding: 5px;*/
    text-align: left;   
    vertical-align:top 
}
body{
  word-wrap: break-word;
  font-family:  'sans-serif','Arial';
  font-size: 11px;
  /*height: 210mm;*/
}
.style_hidden{
  border-style: hidden;
}
.fixed_table{
  table-layout:fixed;
}
.text-center{
  text-align: center;
}
.text-left{
  text-align: left;
}
.text-right{
  text-align: right;
}
.text-bold{
  font-weight: bold;
}
.bg-sky{
  background-color: #E8F3FD;
}
@page { size: A5 margin: 5px; }
body { margin: 5px; }

 #clockwise {
       rotate: 90;
    }

    #counterclockwise {
       rotate: -90;
    }
</style>
</head>
<body onload="window.print();"><!-- window.print() -->

<caption>
      <center>
        <span style="font-size: 18px;text-transform: uppercase;">
        <i class="fa fa-globe"></i> Order Invoice
        </span>
      </center>
</caption>

<table autosize="1" style="overflow: wrap" id='mytable' align="center" width="100%" height='100%'  cellpadding="0" cellspacing="0"  >

  
    <thead>

      <tr>
        <th colspan="16">
          <table width="100%" height='100%' class="style_hidden fixed_table">
              <tr>
                <!-- First Half -->
                
                <td colspan="8">
                  <div class="company-details">
                    <div class="company-logo">
                        <img src="https://test.netiias.com/images/Neti-logo.svg#full"/>
                    </div>
                    <div class="company-name">Adhyayanam</div>
                    <div class="company-address">Viaspir, Post Basahiya, Atrouliya, Azamgarh,Uttar Pradesh, India
Pin Code - 223223 </div>
                    <div class="company contact">
                      Contact Number:+91-91209 30909<br>
                      Email Id: adhyayaniasacademy@gmail.com<br>
                    </div>
                </div>
                </td>

                <!-- Second Half -->
                <td colspan="8" rowspan="1">
                  <span>
                    <table style="width: 100%;" class="style_hidden fixed_table">
                        <tr>
                          <td colspan="8">
                           {{$order->student->name ?? ''}}
                          </td>
                        </tr>
                        @if($order->student->full_address !='')
                        <tr>
                          <td colspan="8">
                           {{$order->student->full_address ?? ''}}
                          </td>
                        </tr>
                      
                      @endif
                        <tr>
                          <td colspan="8">
                            Phone : 
                            <span style="font-size: 10px;">
                              <b>{{$order->student->mobile ?? ''}}</b>
                            </span>
                          </td>
                        </tr>
                         <tr>
                          <td colspan="8">
                            Email : 
                            <span style="font-size: 10px;">
                              <b>{{$order->student->email ?? ''}}</b>
                            </span>
                          </td>
                        </tr>
                         <tr>
                          <td colspan="8">
                            Order Date & Time : 
                            <span style="font-size: 10px;">
                              <b>{{date('d-m-Y g:i A', strtotime($order->created_at))}}</b>
                            </span>
                          </td>
                        </tr>
                         <tr>
                          <td colspan="8">
                            Order Id : 
                            <span style="font-size: 10px;">
                              <b>{{$order->order_code ?? ''}}</b>
                            </span>
                          </td>
                        </tr>
                         <tr>
                          <td colspan="8">
                            Order Type : 
                            <span style="font-size: 10px;">
                              <b>{{$order->order_type ?? ''}}</b>
                            </span>
                          </td>
                        </tr>
                         <tr>
                          <td colspan="8">
                            Payment Status : 
                            <span style="font-size: 10px;">
                              <b>{{$order->payment_status ?? ''}}</b>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="8">
                            Transaction Id : 
                            <span style="font-size: 10px;">
                              <b>{{$order->transaction_id ?? ''}}</b>
                            </span>
                          </td>
                        </tr>
                        


                       
                        


                    
                    </table>
                  </span>
                </td>
              </tr>

              




            
          </table>
      </th>
      </tr>

      <tr>
        <td colspan="16">&nbsp; </td>
      </tr>
      <tr class="bg-sky"><!-- Colspan 10 -->
        <th colspan='2' class="text-center">Sr. No</th>
        <th colspan='4' class="text-center" >Order Type</th>
        
        <th colspan='4' class="text-center">Detail</th>
        <th colspan='3' class="text-center">Quantity</th>
        <th colspan='3' class="text-center">Rates</th>
        
      </tr>
  </thead>



<tbody>
    
  <tr>
    <td colspan='16'>
        <tr>
            <td colspan='2' class='text-center'>1</td>
            <td colspan='4' class='text-center'>{{$order->order_type}}</td>
            <td colspan='4' class='text-center'>{{$order->detail ?? ''}}</td>
            <td colspan='3' class='text-center'>{{$order->quantity ?? 0}}</td>
            <td colspan='3' class='text-center'>&#8377;{{$order->billed_amount ?? 0}}</td>
         </tr>  
  
      </td>
  </tr>
  <tr>
        <td colspan="16">&nbsp; </td>
      </tr>
  </tbody>


<tfoot>
 

<tr class="bg-sky">
    <td colspan="12" class='text-right text-bold'>Sub Total: </td>
    <td colspan="4" class='text-right text-bold'>&#8377;{{$order->billed_amount ?? 0}}</td>
</tr>
<tr class="bg-sky">
    <td colspan="12" class='text-bold text-right'>Discount({{$order->discount ?? 0}}%): </td>
    <td colspan="4" class='text-bold text-right'>&#8377;{{$order->discount_amount ?? 0}}</td>
</tr>
<tr class="bg-sky">
    <td colspan="12" class='text-bold text-right'>Taxes({{$order->tax ?? 0}}%): </td>
    <td colspan="4" class='text-bold text-right'>&#8377;{{$order->tax ?? 0}}</td>
</tr>
<tr class="bg-sky">
    <td colspan="12" class='text-bold text-right'>Total: </td>
    <td colspan="4" class='text-bold text-right'>&#8377;{{$order->total ?? 0}}</td>
</tr>
  
  
  
  



      
           
          </table>
      </td>
      </tr>
      <!-- T&C & Bank Details & signatories End -->

  
</tfoot>

</table>

</body>
</html>

