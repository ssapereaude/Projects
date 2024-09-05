package test;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertTrue;
import static org.junit.jupiter.api.Assertions.assertAll;

import org.junit.Test;
import org.junit.jupiter.api.DisplayName;
import org.junit.jupiter.api.RepeatedTest;

import utils.classes.MysteryBox;
import utils.classes.Payment;
import utils.classes.Result;

public class TestCases {

    @RepeatedTest(10)
    @DisplayName("Ensure mystery boxes don't exceed prize of €50 and isn't less than €2")
    public void testMysteryBox() {
        MysteryBox mysteryBox = new MysteryBox();
        assertTrue("The prize doesn't exceed €50", mysteryBox.open() <= 50);
        assertTrue("The prize isn't less than €2", mysteryBox.open() >= 2);
    }

    @Test
    @DisplayName("Test Payment class")
    public void testPayment() {
        Payment payment = new Payment("29/04/2023", "16:23", "20");

        assertAll("Payment tests",

                () -> assertEquals("29/04/2023", payment.getDate()),
                () -> assertEquals("16:23", payment.getTime()),
                () -> assertEquals("€ 20", payment.getAmount())

        );
    }

    @Test
    @DisplayName("Test Result class")
    public void testResult() {
        Result result = new Result("29/04/2023", "5.0", "1.25", "mines");

        assertAll("Result tests",

                () -> assertEquals("29/04/2023", result.getDate()),
                () -> assertEquals("€ 5.00", result.getBet()),
                () -> assertEquals("1.25", result.getMultiplier()),
                () -> assertTrue(result.getIsWin())

        );
    }

}
