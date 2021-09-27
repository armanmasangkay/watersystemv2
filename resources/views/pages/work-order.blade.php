<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Macrohon Water System - Work Order</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-macrohon.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @for($i = 0; $i < 2; $i++)
            <div class="col-md-6">
                <table class="table mt-3 mb-0">
                    <tr>
                        <td class="border-bottom-0 pt-1 ps-3 float-end">
                            <img src="{{ asset('assets/img/logo-macrohon.png') }}" width="150" class="m-0 d-inline-block ms-2" alt="logo">
                        </td>
                        <td class="border-bottom-0 pt-3 ps-3 pe-0">
                            <div class="text-left ps-0 d-inline-block mt-2">
                                <h4 class="ms-2 mt-1 mb-0">Republic of the Philippines</h4>
                                <h4 class="mb-0 mt-1"><strong>Province of Southern Leyte</strong></h4>
                                <h4 class="ms-2 mt-1"><i>Municipality of Macrohon</i></h4>
                            </div>
                        </td>
                    </tr>
                </table>
                <table class="table mb-0">
                    <tr>
                        <td colspan="3" class="border-bottom-0 pt-4 text-center"><h3 class="float-end"><strong>WORK ORDER REQUEST</strong></32></td>
                        <td colspan="2" class="border-bottom-0 display-6 pt-4 text-right"><h3 class="float-end"><strong>#: <span class="text-danger">MAR2021-001</span></strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="border-bottom-0 pt-3 text-center"></td>
                    </tr>
                </table>
                <table class="table mb-0">
                    <tr>
                        <td class="border bg-light text-primary"><strong>DATE : </strong></td>
                        <td colspan="2" class="border">September 22, 2021</td>
                        <td class="border bg-light text-primary"><strong>TYPE OF SERVICES : </strong></td>
                        <td class="border">New Connection</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border py-0 bg-light text-primary"><strong>NAME OF APPLICANT</strong></td>
                        <td class="border py-0 bg-light text-primary px-1"><strong>ACCOUNT NO.</strong></td>
                        <td class="border py-0 bg-light text-primary"><strong>CONTACT NO.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="3" class="border-start border-bottom-0 py-0 ">
                            <table class="table mb-0">
                                <tr>
                                    <td class="border-0 text-center"><strong>MASOB</strong></td>
                                    <td class="border-0 text-center"><strong>NOBEGIN</strong></td>
                                    <td class="border-0 text-center"><strong>A.</strong></td>
                                </tr>
                                <tr>
                                    <td class="border-0 py-0 text-muted text-center"><i>Entity/Family Name</i></td>
                                    <td class="border-0 py-0 text-muted text-center"><i>First Name</i></td>
                                    <td class="border-0 py-0 text-muted text-center"><i>Middle Name</i></td>
                                </tr>
                            </table>
                        </td>
                        <td class="border-start border-bottom-0 py-3 text-center px-1 display-5"><h2 class="text-danger"><strong>0004</strong></h2></td>
                        <td class="border-start border-bottom-0 border-end py-3 text-center">09367653842</td>
                    </tr>
                </table>
                <table class="table mb-0">
                    <tr>
                        <td colspan="3" class="border py-0 bg-light text-primary"><strong>PLACE OF CONNECTION</strong></td>
                        <td colspan="2" class="border py-0 bg-light text-primary text-center"><strong>TYPE OF CONNECTION</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="3" class="border-start border-bottom-0 py-0">
                            <table class="table mb-0">
                                <tr>
                                    <td class="border-0 text-center"><strong>&nbsp;</strong></td>
                                    <td class="border-0 text-center"><strong>&nbsp;</strong></td>
                                    <td class="border-0 text-center"><strong>ILIHAN</strong></td>
                                </tr>
                                <tr>
                                    <td class="border-0 py-0 text-muted text-center"><i>Street Name</i></td>
                                    <td class="border-0 py-0 text-muted text-center"><i>Sitio/Purok</i></td>
                                    <td class="border-0 py-0 text-muted text-center"><i>Barangay</i></td>
                                </tr>
                            </table>
                        </td>
                        <td class="border-start border-bottom-0 border-end py-3 text-center px-1 display-5"><h3>Residential</h3></td>
                    </tr>
                </table>
                <table class="table mb-0">
                    <tr>
                        <td colspan="5" class="border py-0 bg-light text-primary"><strong>ADDITIONAL REMARKS/DESCRIPTION</strong></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="py-0 border-start border-end">
                            <textarea name="" id="" rows="3" class="w-100 border-0"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border py-0 bg-light text-primary"><strong>REQUESTED BY: </strong></td>
                        <td colspan="2" class="border py-0 bg-light text-primary"><strong>APPROVED BY: </strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="3" class="border-start border-bottom-0 py-0">
                            <table class="table mt-4 mb-3">
                                <tr>
                                    <td class="border-0 text-center"><strong>ARLAN AUGUSTINE HEIG A. ESTELA</strong></td>
                                </tr>
                                <tr>
                                    <td class="border-0 py-0 text-muted text-center"><i>Internal Auditor 1</i></td>
                                </tr>
                            </table>
                        </td>
                        <td rowspan="2" colspan="2" class="border-start border-bottom-0 border-end py-0">
                            <table class="table mt-4 mb-3">
                                <tr>
                                    <td class="border-0 text-center"><strong>ENGR. SARAH P. DAMPOG, CE, MPA</strong></td>
                                </tr>
                                <tr>
                                    <td class="border-0 py-0 text-muted text-center"><i>Internal Auditor 1</i></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="table mb-5">
                    <tr>
                        <td colspan="5" class="border py-0 bg-light text-primary"><strong>WATERWORKS FIELD PERSONEL FEEDBACK</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border-start border-end-0 border-bottom-0"><input type="text" readOnly class="bg-white ms-5 me-2 border border-secondary" style="width: 50px;"><span>Completed/Installed</span></td>
                        <td colspan="2" class="border-start border-start-0 border-end border-bottom-0"><span>Date Installed/Performed</span><input type="text" readOnly class="bg-white border-top-0 border-start-0 ms-3 border-end-0 border-1 border-secondary"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border-start border-end-0 border-bottom-0"><input type="text" readOnly class="bg-white ms-5 me-2 border border-secondary" style="width: 50px;"><span>Not Performed</span></td>
                        <td colspan="2" class="border-start border-start-0 border-end border-bottom-0"><span>Meter Reading</span><input type="text" readOnly class="bg-white border-top-0 border-start-0 border-end-0 ms-3 border-1 border-secondary"></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="border py-0 px-0">
                            <table class="table mb-0">
                                <tr>
                                    <td colspan="4" class="border-top-0 border-start-0 border-end-0 border-bottom py-0 bg-light text-primary"><strong>OTHER REMARKS/ISSUES/CONCERN :</strong></td>
                                </tr>
                                <tr>
                                    <td class="border-0 py-0">
                                        <textarea name="" col="10" class="border-0 w-100" id="" rows="5"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="1" rowspan="2" class="border py-0">
                            <table class="table mt-3">
                                <tr>
                                    <td class="border-start border-start-0 border-end-0 border-bottom-0"><span>Meter Number</span><input type="text" readOnly class="bg-white border-top-0 border-start-0 border-end-0 ms-3 border-1 border-secondary"></td>
                                </tr>
                                <tr>
                                    <td class="border-0" align="center">
                                        <input type="text" class="w-50 border-top-0 border-start-0 border-end-0 border-1 border-secondary mt-4">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            @endfor
        </div>
    </div>
</body>
</html>