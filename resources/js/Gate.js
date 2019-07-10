export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.role_id === 1;
    }

    isOperator(){
        return this.user.role_id === 2;
    }

    isSales(){
        return this.user.role_id === 3;
    }

    isAdminOrOperator(){
        if(this.user.role_id === 1 || this.user.role_id === 2){
            return true;
        }
    }

    isAdminOrSales(){
        if(this.user.role_id === 1 || this.user.role_id === 3){
            return true;
        }
    }

    token(){
        return this.user.api_token;
    }

}
