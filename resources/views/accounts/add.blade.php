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
        let productList = [];
        let amount = 0;
        function addToCart() {
            let description = $('#product').val();
            let unit_price = $('#unit_price').val();
            let quantity = $('#quantity').val();
            amount += unit_price * quantity;
            var product = {description:description, unit_price:unit_price, quantity:quantity};
            productList.push(product);
            console.log(productList);
            $('#description').val(JSON.stringify(productList));
            $('#amount').val(amount);
            $('#pay').val(amount);
            $('#due').val(0);
            let bodyText = '<tr>';
            bodyText+= '<td>'+description+'</td>';
            bodyText+= '<td>'+quantity+'</td>';
            bodyText+= '<td>'+unit_price+'</td>';
            bodyText+= '<td>'+unit_price * quantity+'</td>';
            bodyText+= '</tr>';
            $('.product-body').append(bodyText);
        }

        function getDue() {
            let amountPayable = $('#amount').val();
            let amountPaid = $('#pay').val();
            if(parseFloat(amountPaid) > parseFloat(amountPayable)) {
               $('#pay').val(amountPayable);
               amountPaid = amountPayable;
            } else if(amountPaid === '') {
                $('#pay').val(0);
                amountPaid = 0;
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
        #product-form {
            border: 10px solid gainsboro;
            margin: 2%;
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
                    <div class="col-md-8">
                        <!--begin::Form-->
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <div class="col-7">
                                    <input class="form-control m-input" type="text" id="product" name="product"
                                           placeholder="Product description">
                                </div>
                                <div class="col-2">
                                    <input class="form-control m-input" type="number" id="unit_price" name="unit_price"
                                           placeholder="Unit price">
                                </div>
                                <div class="col-2">
                                    <input class="form-control m-input" type="number" id="quantity" name="quantity"
                                           placeholder="Quantity">
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-success" onclick="addToCart()"> Add</button>
                                </div>
                            </div>
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody class="product-body">
                                </tbody>
                            </table>
                        </div>
                        <!--end::Form-->
                    </div>
                    <div class="col-md-4">
                        <form class="m-form" id="product-form" method="POST" action="{{route('add_account')}}">
                            {{ csrf_field() }}
                            <div class="m-portlet__body">
                                <input class="form-control m-input" type="hidden" id="description" name="description">
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label"> Customer </label>
                                    <div class="col-10">
                                        <select class="form-control m-input m-input--air" id="customer_id"
                                                name="customer_id">
                                            <option value="">Select One</option>
                                            @foreach($customers as $row)
                                            <option value="{{$row->id}}">{{$row->name . ' ('. $row->mobile .')'}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-tel-input" class="col-2 col-form-label"> Invoice </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="text" id="invoice" name="invoice">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-tel-input" class="col-2 col-form-label"> Amount </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="number" id="amount" name="amount" readonly>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-number-input" class="col-2 col-form-label"> Pay </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="number" id="pay" name="pay" oninput="getDue()">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-number-input" class="col-2 col-form-label"> Due </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="number" id="due" name="due" readonly>
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
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>

@endsection
