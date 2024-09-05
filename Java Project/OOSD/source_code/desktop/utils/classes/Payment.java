package utils.classes;

public class Payment {

    private String date;
    private String time;
    private String amount;

    public Payment(String date, String time, String amount) {
        this.date = date;
        this.amount = amount;
        this.amount += 00;
        this.amount = "€ " + this.amount.substring(0, this.amount.indexOf('.') + 3);

        if (time.indexOf('.') > 0) {
            this.time = time.substring(0, time.indexOf('.'));
        } else {
            this.time = time;
        }
    }

    public String getDate() {
        return date;
    }

    public String getTime() {
        return time;
    }

    public String getAmount() {
        return amount;
    }

    public String toString() {
        return date + "," + time + "," + amount;
    }

}
