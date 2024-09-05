/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import java.awt.Color;
import javax.swing.ImageIcon;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.SwingConstants;
import utils.Colors;
import utils.Fonts;

public class PaymentRecord extends JPanel {

    JLabel[] labels;

    public PaymentRecord(String[] data, int[] offsets, int width, int height, Color color) {

        this.setBackground(color);
        this.setLayout(null);

        labels = new JLabel[4];
        for (int i = 0; i < data.length; i++) {
            labels[i] = new JLabel(data[i]);
            labels[i].setBackground(color);
            labels[i].setForeground(Colors.TEXT);
            labels[i].setFont(Fonts.DEFAULT);
            labels[i].setVerticalAlignment(SwingConstants.CENTER);
            labels[i].setBounds(offsets[i], 0, 180, height);
            this.add(labels[i]);
        }

        labels[3] = new JLabel(new ImageIcon("images/check.png"));
        labels[3].setBackground(color);
        labels[3].setVerticalAlignment(SwingConstants.CENTER);
        labels[3].setBounds(width - offsets[0] - height, 0, height, height);
        this.add(labels[3]);
    }

}
