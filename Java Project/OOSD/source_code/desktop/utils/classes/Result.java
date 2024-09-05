package utils.classes;

public class Result {

    private String date;
    private String bet;
    private String multiplier;
    private String game;
    private boolean isWin;

    public Result(String date, String bet, String multiplier, String game) {
        isWin = Double.parseDouble(multiplier) > 0;
        this.date = date;
        this.bet = bet;
        this.bet += 00;
        this.bet = "€ " + this.bet.substring(0, this.bet.indexOf('.') + 3);
        if (Double.parseDouble(multiplier) == 0) {
            this.multiplier = "0.00";
        } else {
            if (multiplier.indexOf('.') >= 0) {
                this.multiplier = multiplier + "00";
                this.multiplier = this.multiplier.substring(0, this.multiplier.indexOf('.') + 3);
            } else {
                this.multiplier = multiplier + ".00";
            }
        }
        this.game = game;
    }

    public String getDate() {
        return date;
    }

    public String getBet() {
        return bet;
    }

    public String getMultiplier() {
        return multiplier;
    }

    public String getGame() {
        return game;
    }

    public boolean getIsWin() {
        return isWin;
    }

}
