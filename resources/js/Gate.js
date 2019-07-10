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

    token(){
        return this.user.api_token;
    }

}
