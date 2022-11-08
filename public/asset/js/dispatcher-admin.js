'use strict';

class DispatcherPanel extends React.Component {
    componentWillMount() {
        this.setState({
            listContent: 'dispatch-map'
        });
    }

    handleUpdateBody(body) {
        console.log('Body Update Called', body);
        this.setState({
            listContent: body
        });
    }

    handleUpdateFilter(filter) {
        console.log('Filter Update Called', this.state.listContent);
        if(filter == 'all'){
            this.setState({
                listContent: 'dispatch-map'
            });
        }else if(filter == 'assigned'){
            this.setState({
                listContent: 'dispatch-assigned'
            });
        }else if(filter == 'cancelled'){
            this.setState({
                listContent: 'dispatch-cancelled'
            });
        }else if(filter == 'return'){
            this.setState({
                listContent: 'dispatch-return'
            });
        }else{
            this.setState({
                listContent: 'dispatch-map'
            });
        }
    }

    handleRequestShow(trip, event) {
        console.log('Show Request', trip);
        if(trip.status == 'CANCELLED') {
            this.setState({
                listContent: 'dispatch-cancelled',
                trip: trip
            });
        } else {
            if(trip.provider_auto_assign) {
                this.setState({
                    listContent: 'dispatch-map',
                    trip: trip
                });
            } else if(trip.current_provider_id == 0) {
                this.setState({
                    listContent: 'dispatch-assign',
                    trip: trip
                });

            } else {
                this.setState({
                    listContent: 'dispatch-map',
                    trip: trip
                });
            }
        }
        
        ongoingInitialize(trip);
    }

    handleAutoRequest(trip) {
        if(trip.status == 'SEARCHING' && trip.current_provider_id != 0) {
            this.setState({
                listContent: 'dispatch-map',
                trip: trip
            });
            $('.notification').remove();
            $('.container-fluid').first().before('<div class="alert alert-danger notification"><button type="button" class="close" data-dismiss="alert">×</button><p style="margin-top:10px;">Ride is auto assigned. You cannot manually assign drivers.</p></div>');
            setTimeout(function() { $('.notification').fadeOut('fast', 'linear', function() { $('.notification').delay(5000).remove(); }); }, 5000);
        }
        
    }

    handleRequestCancel(argument) {
        this.setState({
            listContent: 'dispatch-map'
        });
    }

    render() {

        let listContent = null;

        // console.log('DispatcherPanel', this.state.listContent);

        switch(this.state.listContent) {
            case 'dispatch-create':
                listContent = <div className="col-md-4" style={{ paddingRight: 0 + 'px'}}>
                        <DispatcherRequest completed={this.handleRequestShow.bind(this)} cancel={this.handleRequestCancel.bind(this)} />
                    </div>;
                break;
            case 'dispatch-map':
                listContent = <div className="col-md-4"  style={{ height: '600px', padding: '0px'}}>
                        <DispatcherList clicked={this.handleRequestShow.bind(this)} checked={this.handleAutoRequest.bind(this)} />
                    </div>;
                break;
            case 'dispatch-assigned':
                listContent = <div className="col-md-4" style={{ height: '600px', padding: '0px'}}>
                        <DispatcherAssignedList />
                    </div>;
                break;
            case 'dispatch-cancelled':
                listContent = <div className="col-md-4"  style={{ height: '600px', padding: '0px'}}>
                        <DispatcherCancelledList clicked={this.handleRequestShow.bind(this)} cancel={this.handleRequestCancel.bind(this)} />
                    </div>;
                break;
            case 'dispatch-assign':
                listContent = <div className="col-md-4" style={{ height: '600px', padding: '0px'}}>
                        <DispatcherAssignList trip={this.state.trip} />
                    </div>;
                break;
        }

        return (
            <div className="container-fluid">
                <div className="card m-b-20">
                    <div className="card-header">
                        <DispatcherNavbar body={this.state.listContent} updateBody={this.handleUpdateBody.bind(this)} updateFilter={this.handleUpdateFilter.bind(this)}/>
                    </div>
                    <div className="card-body" style={{padding: 0 + 'px'}}>
                        <div className="row" style={{ marginRight: 0 + 'px', marginLeft: 0 + 'px'}}>
                            { listContent }

                            <div className="col-md-8" style={{ padding: '0px'}}>
                                <DispatcherMap body={this.state.listContent} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );

    }
};

class DispatcherNavbar extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            body: 'dispatch-map',
            selected:''
        };
    }

    filter(data) {
        console.log('Navbar Filter', data);
        this.setState({selected  : data})
        this.props.updateFilter(data);
    }

    handleBodyChange() {
        // console.log('handleBodyChange', this.state);
        if(this.props.body != this.state.body) {
            this.setState({
                body: this.props.body
            });
        }

        if(this.state.body == 'dispatch-map') {
            this.props.updateBody('dispatch-create');
            this.setState({
                body: 'dispatch-create'
            });
        }else if(this.state.body == 'dispatch-assigned') {
            this.props.updateBody('dispatch-map');
            this.setState({
                body: 'dispatch-assigned'
            });
        }else if(this.state.body == 'dispatch-cancelled') {
            this.props.updateBody('dispatch-map');
            this.setState({
                body: 'dispatch-cancelled'
            });
        } else {
            this.props.updateBody('dispatch-map');
            this.setState({
                body: 'dispatch-map'
            });
        }
    }

    isActive(value){
        return 'nav-link '+((value===this.state.selected) ?'btn-primary':'btn-light');
    }

    render() {

        return (
            <div className="row">
                <div className="col-sm-6" id="process-filters">
                    <ul className="nav nav-pills nav-justified" role="tablist">
                        <li className="nav-item" onClick={this.filter.bind(this, 'all')}>
                            <span className={this.isActive('all')} href="#">Em pesquisa</span>
                        </li>
                        <li className="nav-item" onClick={this.filter.bind(this, 'assigned')}>
                            <span className={this.isActive('assigned')} href="#">Atribuídos ao Motorista</span>
                        </li>
                        <li className="nav-item" onClick={this.filter.bind(this, 'cancelled')}>
                            <span className={this.isActive('cancelled')} href="#">Cancelados</span>
                        </li>
                    </ul>
                </div>
                <div className="col-sm-6 d-flex justify-content-end button-items">
                    <button type="button" 
                        onClick={this.handleBodyChange.bind(this)} 
                        className="btn btn-success btn-md label-right b-a-0 waves-effect waves-light">
                        <span className="btn-label"><i className="ti-plus"></i></span>
                        NOVA VIAGEM
                    </button>
                </div>
            </div>

        );
    }
}

class DispatcherList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                data: []
            }
        };
    }

    componentDidMount() {
        window.worldMapInitialize();
        window.Moob.TripTimer = setInterval(
            () => this.getTripsUpdate(),
            1000
        );
    }

    componentWillUnmount() {
        clearInterval(window.Moob.TripTimer);
    }

    getTripsUpdate() {
        $.get('/admin/dispatcher/trips?type=SEARCHING', function(result) {
            if(result.hasOwnProperty('data')) {
                this.setState({
                    data: result
                });
            } else {
                this.setState({
                    data: {
                        data: []
                    }
                });
            }
        }.bind(this));
    }

    handleClick(trip) {
        this.props.checked(trip);
        this.props.clicked(trip);
    }

    render() {
        return (
            <div className="card">
                <div className="card-header text-uppercase"><b>Lista de Viagens em Pesquisa</b></div>
                <DispatcherListItem data={this.state.data.data} clicked={this.handleClick.bind(this)} />
            </div>
        );
    }
}

class DispatcherAssignedList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                data: []
            }
        };
    }

    componentDidMount() {
        window.worldMapInitialize();
        window.Moob.TripTimer = setInterval(
            () => this.getTripsUpdate(),
            1000
        );
    }

    componentWillUnmount() {
        clearInterval(window.Moob.TripTimer);
    }

    getTripsUpdate() {
        $.get('/admin/dispatcher/trips?type=ASSIGNED', function(result) {
            if(result.hasOwnProperty('data')) {
                this.setState({
                    data: result
                });
            } else {
                this.setState({
                    data: {
                        data: []
                    }
                });
            }
        }.bind(this));
    }

    render() {
        return (
            <div className="card">
                <div className="card-header text-uppercase"><b>Viagens Atribuídas</b></div>
                <DispatcherAssignedListItem data={this.state.data.data} />
            </div>
        );
    }
}


class DispatcherAssignedListItem extends React.Component {

    render() {
        var listItem = function(trip) {
            return (
                    <div className="il-item" key={trip.id}>
                        <a href="#" className="text-dark" >
                            <div className="inbox-item" style={{paddingRight: 15 + 'px', paddingLeft: 15 + 'px'}}>
                                <h6 className="inbox-item-author mt-0 mb-1">Passageiro: {trip.user.first_name} {trip.user.last_name} </h6>
                                <h6 className="inbox-item-author mt-0 mb-1">Motorista: {trip.provider.first_name} {trip.provider.last_name} </h6>
                                
                                
                                <div className="inbox-item-date">
                                    <p className="text-muted">{trip.updated_at}</p>
                                    <div className="order-table d-flex justify-content-end ">
                                    {trip.status == 'COMPLETED' ?
                                        <span className="badge badge-primary badge-pill"><i className="mdi mdi-checkbox-blank-circle text-primary"></i>  CONCLUÍDA </span>
                                    : trip.status == 'ASSIGNED' ?
                                        <span className="tag tag-danger pull-right"> ATRIBUÍDA </span>
                                    : trip.status == 'CANCELLED' ?
                                        <span className="tag tag-danger pull-right"> CANCELADA </span>
                                    : trip.status == 'SEARCHING' ?
                                        <span className="tag tag-warning pull-right"> PESQUISANDO </span>
                                    : trip.status == 'SCHEDULED' ?
                                        <span className="tag tag-primary pull-right"> AGENDADA </span>
                                    : trip.status == 'STARTED' ?
                                        <span className="badge badge-success badge-pill"><i className="mdi mdi-checkbox-blank-circle text-success"></i>  A CAMINHO </span>
                                    : trip.status == 'ARRIVED' ?
                                        <span className="badge badge-info badge-pill"><i className="mdi mdi-checkbox-blank-circle text-info"></i>  NO LOCAL </span>
                                    : trip.status == 'PICKEDUP' ?
                                        <span className="badge badge-dark badge-pill"><i className="mdi mdi-checkbox-blank-circle text-dark"></i>  EM VIAGEM </span>
                                    : trip.status == 'DROPPED' ?
                                        <span className="badge badge-warning badge-pill"><i className="mdi mdi-checkbox-blank-circle text-warning"></i>  NO DESTINO </span>
                                    : 
                                        <span className="tag tag-info pull-right"> {trip.status} </span>
                                    }
                                    </div>
                                </div>
                                

                                <p>De: {trip.s_address} Para: {trip.d_address ? trip.d_address : "Não selecionado"}</p>
                            </div>
                        </a>        
                    </div>
                );
        }.bind(this);

        return (
            <div className="inbox-wid" style={{height: 600 + 'px', overflowY: 'scroll'}}>
                {this.props.data.map(listItem)}
            </div>
        );
    }
}

class DispatcherCancelledList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                data: []
            }
        };
    }

    componentDidMount() {
        window.worldMapInitialize();
        window.Moob.TripTimer = setInterval(
            () => this.getTripsUpdate(),
            1000
        );
    }

    componentWillUnmount() {
        clearInterval(window.Moob.TripTimer);
    }

    getTripsUpdate() {
        $.get('/admin/dispatcher/trips?type=CANCELLED', function(result) {
            if(result.hasOwnProperty('data')) {
                this.setState({
                    data: result
                });
            } else {
                this.setState({
                    data: {
                        data: []
                    }
                });
            }
        }.bind(this));
    }

    handleClick(trip) {
        this.props.clicked(trip);
    }


    cancelCreate() {
        this.props.cancel(true);
    }


    render() {
        return (
            <div className="card">
                <div className="card-header text-uppercase"><b>Viagens Canceladas</b></div>
                <div className="card-body" style={{padding: 0 + 'px'}}>
                    <DispatcherCancelledListItem data={this.state.data.data} clicked={this.handleClick.bind(this)} cancel={this.cancelCreate.bind(this)}  />
                </div>
            </div>
        );
    }
}


class DispatcherCancelledListItem extends React.Component {

    handleClick(trip) {
        this.props.clicked(trip)
    }

    cancelCreate(trip) {
        $.get('/admin/dispatcher/resend?request_id='+trip.id, function(result) {
            console.log(result)
            if(result.message != null) {
                 toastr.error(result.message);
            } else if (result.error) {
                 toastr.error(result.error);
            } else {
                this.props.cancel(true);   
            }
        }.bind(this));
    }

    requestDetails(trip) {
        location.assign("/admin/requests/"+trip.id);
    }


    userDetails(trip) {
        location.assign("/admin/user/"+trip.user_id);
    }

    estameteFire(trip){
       return trip.estimated_fare.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
    }

    render() {
        var listItem = function(trip) {
            return (
                    <div className="inbox-item">
                        <a href="#" className="text-dark" key={trip.id}  onClick={this.handleClick.bind(this, trip)}>
                            <div  style={{paddingRight: 15 + 'px', paddingLeft: 15 + 'px'}}>
                                <h6 className="inbox-item-author mt-0 mb-1">{trip.user.first_name} {trip.user.last_name} </h6>
                                <p className="inbox-item-text text-muted mb-0">Motivo de cancel: {trip.cancel_reason}</p>
                                <p className="inbox-item-date text-muted"  style={{paddingRight: 15 + 'px', paddingLeft: 15 + 'px'}}>{trip.updated_at_pt_br}</p>

                                <p>De: {trip.s_address} Para: {trip.d_address ? trip.d_address : "Não selecionado"}</p>
                                <p>Tarifa estimada: { this.estameteFire(trip) }</p>

                                
                            </div>
                        </a>
                        <div className="button-items" style={{paddingRight: 15 + 'px', paddingLeft: 15 + 'px'}}>
                            <a className="text-white btn btn-primary" onClick={this.cancelCreate.bind(this, trip)} > <i className="mdi mdi-account-convert"></i> REENVIAR</a>
                            <button onClick={this.requestDetails.bind(this, trip)}  type="button" className="btn btn-info waves-effect waves-light">DETALHES</button>
                            <button onClick={this.userDetails.bind(this, trip)} type="button" className="btn btn-success waves-effect waves-light">PASSAGEIRO</button>
                        </div>
                        
                    </div>
                );
        }.bind(this);

        return (
            <div className="inbox-wid" style={{height: 600 + 'px', overflowY: 'scroll'}}>
                {this.props.data.map(listItem)}
            </div>
        );
    }
}

class DispatcherListItem extends React.Component {
    handleClick(trip) {
        this.props.clicked(trip)
    }

    handleCancel(trip, event) {
        event.stopPropagation();
        location.assign("/admin/dispatcher/cancel?request_id="+trip.id);
    }

    estimateFire(trip){
       return trip.estimated_fare.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
    }


    render() {
        var listItem = function(trip) {
            return (
                    <div className="il-item" key={trip.id} onClick={this.handleClick.bind(this, trip)}>
                        <a href="#" className="text-dark" >
                            <div className="inbox-item" style={{paddingRight: 15 + 'px', paddingLeft: 15 + 'px'}}>
                                <h6 className="inbox-item-author mt-0 mb-1">{trip.user.first_name} {trip.user.last_name} </h6>
                                <div className="inbox-item-date">
                                    <div className="order-table d-flex justify-content-end ">
                                        {trip.status == 'COMPLETED' ?
                                            <span className="tag tag-success pull-right"> CONCLUÍDA </span>
                                        : trip.status == 'CANCELLED' ?
                                            <span className="tag tag-danger pull-right"> CANCELADA </span>
                                        : trip.status == 'SEARCHING' ?
                                            <span className="badge badge-success badge-pill"><i className="mdi mdi-checkbox-blank-circle text-success"></i>  PESQUISANDO </span>
                                        : trip.status == 'SCHEDULED' ?
                                            <span className="badge badge-warning badge-pill"><i className="mdi mdi-checkbox-blank-circle text-warning"></i> AGENDADA </span>
                                        : 
                                            <span className="tag tag-info pull-right"> {trip.status} </span>
                                        }
                                    </div>
                                </div>
                                <p>De: {trip.s_address} Para: {trip.d_address ? trip.d_address : "Não selecionado"}</p>

                                <h6 className="media-heading">Tarifa Estimada: { this.estimateFire(trip) }</h6>
                                <hp>Pagamento: {trip.payment_mode == 'CASH' ? 'DINHEIRO' : 'CARTÃO'}</hp>
                                
                                <progress className="progress progress-success progress-sm btn-block" max="100"></progress>
                                <span className="text-muted">{trip.current_provider_id == 0 ? "Atribuição manual" : "Pesquisa automática"} : {trip.updated_at_pt_br}</span>
                                
                                <button className="btn btn-danger btn-block" onClick={this.handleCancel.bind(this, trip)} >CANCELAR BUSCA</button>
                            </div>
                        </a>
                        
                    </div>
                );
        }.bind(this);

        return (
            <div className="inbox-wid" style={{height: 600 + 'px', overflowY: 'scroll'}}>
                {this.props.data.map(listItem)}
            </div>
        );
    }
}

class DispatcherRequest extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            data: []
        };
    }

    componentDidMount() {

        // Auto Assign Switch
        //new Switchery(document.getElementById('provider_auto_assign'));
        
        // Schedule Time Datepicker
        $('#schedule_time').datetimepicker({
            minDate: window.Moob.minDate,
            maxDate: window.Moob.maxDate,
        });

        // Get Service Type List
        $.get('/admin/service', function(result) {
            this.setState({
                data: result
            });
        }.bind(this));

        // Mount Ride Create Map

        window.createRideInitialize();

        function stopRKey(evt) { 
            var evt = (evt) ? evt : ((event) ? event : null); 
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
        } 

        document.onkeypress = stopRKey; 
    }

    createRide(event) {
        console.log(event);
        event.preventDefault();
        event.stopPropagation();
        console.log('Hello', $("#form-create-ride").serialize());
        $.ajax({
            url: '/admin/dispatcher',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken },
            type: 'POST',
            data: $("#form-create-ride").serialize(),
            success: function(data) {
                if(typeof data.message !== 'undefined') {
                    $('.container-fluid').first().before('<div class="alert alert-danger notification"><button type="button" class="close" data-dismiss="alert">×</button><p style="margin-top:10px;">'+data.message+'</p></div>');
                    setTimeout(function() { $('.notification').fadeOut('fast', 'linear', function() { $('.notification').delay(5000).remove(); }); }, 5000);
                }
                console.log('Accept', data);
                this.props.completed(data);
            }.bind(this)
        });
    }

    cancelCreate() {
        this.props.cancel(true);
    }

    render() {
         $('#provider_auto_assign').attr( "switch", 'none');
        return (
            <div className="card shadow-none " id="create-ride" style={{ paddingTop: 12 + 'px' }}>
                <form id="form-create-ride" onSubmit={this.createRide.bind(this)} method="POST">
                    <div className="row" style={{marginRight: 15 + 'px', marginLeft: 15 + 'px'}}>
                        <div className="col-sm-6">
                            <div className="form-group">
                                <label htmlFor="first_name">Nome do Passageiro</label>
                                <input type="text" className="form-control" name="first_name" id="first_name" placeholder="Nome" required />
                            </div>
                        </div>
                        <div className="col-sm-6">
                            <div className="form-group">
                                <label htmlFor="last_name">Sobrenome</label>
                                <input type="text" className="form-control" name="last_name" id="last_name" placeholder="Sobrenome" required />
                            </div>
                        </div>
                        <div className="col-sm-6">
                            <div className="form-group">
                                <label htmlFor="email">E-mail</label>
                                <input type="email" className="form-control" name="email" id="email" placeholder="E-mail"/>
                            </div>
                        </div>
                        <div className="col-sm-6">
                            <div className="form-group">
                                <label htmlFor="mobile">Telefone</label>
                                <input type="text" className="form-control numbers" name="mobile" id="mobile" placeholder="Telefone" required />
                            </div>
                        </div>
                        <div className="col-sm-12">
                            <div className="form-group">
                                <label htmlFor="s_address">Endereço de Partida</label>
                                
                                <input type="text"
                                    name="s_address"
                                    className="form-control"
                                    id="s_address"
                                    placeholder="Endereço de Partida"
                                    required></input>

                                <input type="hidden" name="s_latitude" id="s_latitude"></input>
                                <input type="hidden" name="s_longitude" id="s_longitude"></input>
                            </div>
                            <div className="form-group">
                                <label htmlFor="d_address">Endereço de Destino</label>
                                
                                <input type="text" 
                                    name="d_address"
                                    className="form-control"
                                    id="d_address"
                                    placeholder="Endereço de destino"
                                    required></input>

                                <input type="hidden" name="d_latitude" id="d_latitude"></input>
                                <input type="hidden" name="d_longitude" id="d_longitude"></input>
                                <input type="hidden" name="distance" id="distance"></input>
                            </div>
                            
                            <div className="form-group">
                                <label htmlFor="service_types">Tipo de Serviço</label>
                                <ServiceTypes data={this.state.data} />
                            </div>
                            <div className="form-group">
                                <label htmlFor="estimated" className="estimate_amount">Valor estimado : <span id="estimated">R$ 0,00</span></label>
                            </div>
                            <div className="form-group row">
                                <div className="form-group col-sm-8">
                                    <label className="col-form-label">
                                        Atribuição automática
                                    </label>
                                </div>
                                <div className="form-group col-sm-4 d-flex justify-content-end ">
                                    
                                    <input type="checkbox" id="provider_auto_assign" name="provider_auto_assign" className="js-switch"  data-color="#f59345" defaultChecked />
                                    <label htmlFor="provider_auto_assign" data-on-label="SIM" data-off-label="NÃO"></label>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row"  style={{marginRight: 15 + 'px', marginLeft: 15 + 'px'}}>
                        <div className="col-sm-6">
                            <button id="showbtn" className="btn btn-lg btn-success btn-block waves-effect waves-light" disabled>
                                SOLICITAR
                            </button>
                        </div>
                         <div className="col-sm-6">
                            <button type="button" className="btn btn-lg btn-danger btn-block waves-effect waves-light" onClick={this.cancelCreate.bind(this)}>
                                CANCELAR
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        );
    }
};

class DispatcherAssignList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                data: []
            }
        };
    }

    componentDidMount() {
        $.get('/admin/dispatcher/providers', { 
            service_type: this.props.trip.service_type_id,
            latitude: this.props.trip.s_latitude,
            longitude: this.props.trip.s_longitude
        }, function(result) {
            console.log('Providers', result);
            if(result) {
                result['data']=result;
                this.setState({
                    data: result
                });
                window.assignProviderShow(result.data, this.props.trip);
            } else {
                this.setState({
                    data: {
                        data: []
                    }
                });
                window.providerMarkersClear();
            }
        }.bind(this));
    }

    render() {
        console.log('DispatcherAssignList - render', this.state.data);
        return (
            <div className="card">
                <div className="card-header text-uppercase"><b>Atribuir Motorista</b></div>
                
                <DispatcherAssignListItem data={this.state.data.data} trip={this.props.trip} />
            </div>
        );
    }
}

class DispatcherAssignListItem extends React.Component {
    handleClick(provider) {
        // this.props.clicked(trip)
        console.log('Provider Clicked');
        window.assignProviderPopPicked(provider);
    }
    render() {
        var listItem = function(provider) {
            return (
                    <div className="il-item" key={provider.id} onClick={this.handleClick.bind(this, provider)}>
                        <a className="text-black" href="#">
                            <div className="media">
                                <div className="media-body">
                                    <p className="mb-0-5">{provider.first_name} {provider.last_name}</p>
                                    <h6 className="media-heading">Avaliação: {provider.rating}</h6>
                                    <h6 className="media-heading">Telefone: {provider.mobile}</h6>
                                    <h6 className="media-heading">Tipo: {provider.service.service_type.name}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                );
        }.bind(this);

        return (
            <div className="items-list">
                {this.props.data.map(listItem)}
            </div>
        );
    }
}

class ServiceTypes extends React.Component {
    render() {
        // console.log('ServiceTypes', this.props.data);
        var mySelectOptions = function(result) {
            return <ServiceTypesOption
                    key={result.id}
                    id={result.id}
                    name={result.name} />
        };
        return (
                <select 
                    name="service_type"
                    className="form-control" id="service_type">
                    {this.props.data.map(mySelectOptions)}
                </select>
            )
    }
}

class ServiceTypesOption extends React.Component {
    render() {
        return (
            <option value={this.props.id}>{this.props.name}</option>
        );
    }
};

class DispatcherMap extends React.Component {
    render() {
        return (
            
            <div id="map" style={{ height: '650px'}}></div>
            
        );
    }
}

ReactDOM.render(
    <DispatcherPanel />,
    document.getElementById('dispatcher-panel')
);