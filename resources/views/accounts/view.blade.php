@extends('layouts.master')
@section('include_js')
@parent
<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function getDue() {
        let amountPayable = $('#amount').val();
        let amountPaid = $('#pay').val();
        if(parseFloat(amountPaid) > parseFloat(amountPayable)) {
           $('#pay').val(amountPayable);
           amountPaid = amountPayable;
        }
        let amountDue = amountPayable - amountPaid;

        $('#due').val(amountDue);
    }
</script>
<style>
        .m-widget4 .m-widget4__item .m-widget4__info {
            display: table-cell;
            width: 55%;
            padding-left: 1.2rem;
            padding-right: 1.2rem;
            font-size: 1rem;
            vertical-align: middle;
        }
        .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        font-weight: bold;
    }
    .invoice-box table .center-item {
        text-align: center!important
    }
    .invoice-box table .right-item {
        text-align: right!important
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }


</style>
@endsection
@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Account Details
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{route('accounts')}}" class="m-nav__link">
											<span class="m-nav__link-text">
												Accounts
											</span>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{'add_account'}}" class="m-nav__link">
											<span class="m-nav__link-text">
												New
											</span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                 data-dropdown-toggle="hover" aria-expanded="true">
                <a href="#"
                   class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                    <i class="la la-plus m--hide"></i>
                    <i class="la la-ellipsis-h"></i>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="m-nav">
                                    <li class="m-nav__section m-nav__section--first m--hide">
															<span class="m-nav__section-text">
																Quick Actions
															</span>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-share"></i>
                                            <span class="m-nav__link-text">
																	Activity
																</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                            <span class="m-nav__link-text">
																	Messages
																</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-info"></i>
                                            <span class="m-nav__link-text">
																	FAQ
																</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                            <span class="m-nav__link-text">
																	Support
																</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                    <li class="m-nav__item">
                                        <a href="#"
                                           class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                            Submit
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content">
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                            <h3 class="m-portlet__head-text">
                                Account Info
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <!--begin::Form-->
                        <form class="m-form" name="data-form" method="POST"
                              action="{{route('account_edit',$account->id)}}">
                            {{ csrf_field() }}
                            <div class="m-portlet__body">
                                <input type="hidden" name="id" id="account_id"
                                       value="{{!empty($account->id)?$account->id:''}}">

                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        Customer
                                    </label>
                                    <div class="col-10">
                                        <select class="form-control m-input m-input--air"
                                                id="customer_id" name="customer_id">
                                            <option value="">Select One</option>
                                            @foreach($customers as $row)
                                            <option {{empty($account->
                                                customer_id)?'':$account->customer_id==$row->id?'selected="selected"':""}}
                                                value="{{$row->id}}">{{$row->name . ' ('. $row->mobile .')'}}
                                            </option>
                                            @endforeach
                                        </select></div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-tel-input" class="col-2 col-form-label"> Invoice </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="text" id="invoice" name="invoice"
                                               value="{{!empty($account->invoice)?$account->invoice:''}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-search-input" class="col-2 col-form-label"> Description </label>
                                    <div class="col-10">
                                        <table width="100%">
                                            <tr class="heading"
                                                style="background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                                                <td> Item</td>
                                                <td style="text-align: center"> Quantity</td>
                                                <td style="text-align: right"> Price</td>
                                                <td style="text-align: right"> Amount</td>
                                            </tr>
                                            @foreach($account->description as $item)
                                            <tr class="item">
                                                <td> {{ $item->description }}</td>
                                                <td style="text-align: center"> {{ $item->quantity }}</td>
                                                <td style="text-align: right"> {{ $item->unit_price }}</td>
                                                <td style="text-align: right"> {{ $item->unit_price * $item->quantity
                                                    }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-tel-input" class="col-2 col-form-label"> Amount </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="number"
                                               value="{{!empty($account->amount)?$account->amount:''}}" id="amount"
                                               name="amount">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-number-input" class="col-2 col-form-label"> Pay </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="number"
                                               value="{{!empty($account->pay)?$account->pay:''}}" id="pay" name="pay"  oninput="getDue()">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-number-input" class="col-2 col-form-label"> Due </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="number"
                                               value="{{!empty($account->due)?$account->due:''}}" id="due" name="due">
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-success">
                                                Submit
                                            </button>
                                            <a class="btn btn-secondary" href="{{route('accounts')}}">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <div class="col-md-6">
                        {{--start printable area--}}
                        <div class="m-portlet m-portlet--full-height m-portlet--fit ">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            Voucher
                                        </h3>
                                    </div>
                                </div>

                                <div class="m-portlet__head-tools">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target=".bd-example-modal-xl">Preview
                                    </button>
                                    <button class="btn btn-info" type="button" onclick="printDiv('printableArea')">
                                        Print
                                    </button>
                                    <a href="{{action('AccountsController@downloadPDF')}}" class="btn btn-primary">
                                        <i class="m-nav__link-icon flaticon-download"></i>
                                        <span class="m-nav__link-text"> Download </span>
                                    </a>
                                </div>
                            </div>
                            <div class="m-portlet__body" id="printableArea">
                                <div class="invoice-box">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td colspan="2" class="title">
                                                <img src="{{ asset('image/dream.png') }}"
                                                     style="width:100%; max-width:200px;">
                                            </td>
                                            <td colspan="2">
                                                {{ date("F j, Y, g:i a", strtotime($account->created_at)) }}<br>
                                                Invoice #: {{ $account->invoice }}<br>
                                                Status #: {{ $account->status }}
                                            </td>
                                        </tr>

                                        <tr class="heading">
                                            <td colspan="2"> Customer Info</td>
                                            <td colspan="2"> Company Info</td>
                                        </tr>

                                        <tr class="information">
                                            <td colspan="2">
                                                Name: {{ $account->name }}<br>
                                                Mobile: {{ $account->mobile }}<br>
                                                Address: {{ $account->address }}
                                            </td>

                                            <td colspan="2">
                                                Name: {{ $account->company_name }}<br>
                                                Mobile: {{ $account->company_mobile }}<br>
                                                Address: {{ $account->company_address }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                        <tr class="heading">
                                            <td> Item</td>
                                            <td class="center-item"> Quantity</td>
                                            <td class="right-item"> Price</td>
                                            <td class="right-item"> Amount</td>
                                        </tr>
                                        @foreach($account->description as $item)
                                        <tr class="item">
                                            <td> {{ $item->description }}</td>
                                            <td class="center-item"> {{ $item->quantity }}</td>
                                            <td class="right-item"> {{ $item->unit_price }}</td>
                                            <td class="right-item"> {{ $item->unit_price * $item->quantity }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="total">
                                            <td colspan="2">&nbsp;</td>
                                            <td class="right-item"> Total</td>
                                            <td class="right-item"> {{ $account->amount}}</td>
                                        </tr>
                                        <tr class="total">
                                            <td colspan="2">&nbsp;</td>
                                            <td class="right-item"> Pay</td>
                                            <td class="right-item"> {{ $account->pay}}</td>
                                        </tr>
                                        <tr class="total">
                                            <td colspan="2">&nbsp;</td>
                                            <td class="right-item"> Due</td>
                                            <td class="right-item"> {{ $account->due}}</td>
                                        </tr>
                                        <tr>
                                            <td class="center-item" colspan="4">Powered by: <a href="http://dreamsoftbd.com/">Dream Soft (BD)</a> </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{--end printable area--}}
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="invoice-box">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="2" class="title">
                            <img src="{{ asset('image/dream.png') }}" style="width:100%; max-width:200px;">
                        </td>
                        <td colspan="2">
                            {{ date("F j, Y, g:i a", strtotime($account->created_at)) }}<br>
                            Invoice #: {{ $account->invoice }}<br>
                            Status #: {{ $account->status }}
                        </td>
                    </tr>

                    <tr class="heading">
                        <td colspan="2"> Customer Info</td>
                        <td colspan="2"> Company Info</td>
                    </tr>

                    <tr class="information">
                        <td colspan="2">
                            Name: {{ $account->name }}<br>
                            Mobile: {{ $account->mobile }}<br>
                            Address: {{ $account->address }}
                        </td>

                        <td colspan="2">
                            Name: {{ $account->company_name }}<br>
                            Mobile: {{ $account->company_mobile }}<br>
                            Address: {{ $account->company_address }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr class="heading">
                        <td> Item</td>
                        <td class="center-item"> Quantity</td>
                        <td class="right-item"> Price</td>
                        <td class="right-item"> Amount</td>
                    </tr>
                    @foreach($account->description as $item)
                    <tr class="item">
                        <td> {{ $item->description }}</td>
                        <td class="center-item"> {{ $item->quantity }}</td>
                        <td class="right-item"> {{ $item->unit_price }}</td>
                        <td class="right-item"> {{ $item->unit_price * $item->quantity }}</td>
                    </tr>
                    @endforeach
                    <tr class="total">
                        <td colspan="2">&nbsp;</td>
                        <td class="right-item"> Total</td>
                        <td class="right-item"> {{ $account->amount}}</td>
                    </tr>
                    <tr class="total">
                        <td colspan="2">&nbsp;</td>
                        <td class="right-item"> Pay</td>
                        <td class="right-item"> {{ $account->pay}}</td>
                    </tr>
                    <tr class="total">
                        <td colspan="2">&nbsp;</td>
                        <td class="right-item"> Due</td>
                        <td class="right-item"> {{ $account->due}}</td>
                    </tr>
                    <tr>
                        <td class="center-item" colspan="4">Powered by: <a href="http://dreamsoftbd.com/">Dream Soft (BD)</a> </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
