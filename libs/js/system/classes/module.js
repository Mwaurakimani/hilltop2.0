class system_clock {
    constructor() {
        console.log("clock developed");
    }
    static get_time_date() {
        const today = new Date();

        this.hour = today.getHours();
        this.min = today.getMinutes();
        this.sec = today.getSeconds();
        this.prepand = (this.hour >= 12) ? " PM " : " AM ";

        this.timeProp = `${this.hour} : ${this.min} :${this.sec} ${this.prepand}`;

        this.date = today.toDateString()


        return [this.timeProp, this.date];
    }
}