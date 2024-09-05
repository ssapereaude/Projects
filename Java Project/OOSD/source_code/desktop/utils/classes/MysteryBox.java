package utils.classes;

import java.util.Random;

public class MysteryBox {

    private int prize;

    public MysteryBox() {
        Random rand = new Random();

        int randomNum = rand.nextInt(100);

        if (randomNum < 40) {
            prize = 2;
        } else if (randomNum < 70) {
            prize = 5;
        } else if (randomNum < 85) {
            prize = 10;
        } else if (randomNum < 95) {
            prize = 25;
        } else {
            prize = 50;
        }
    }

    public int open() {
        return prize;
    }

}
